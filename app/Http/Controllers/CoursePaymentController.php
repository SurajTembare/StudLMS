<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursePayment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Throwable;

class CoursePaymentController extends Controller
{
    /**
     * Create a Razorpay order for a paid course.
     */
    public function checkout($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        // Only paid courses can use Razorpay checkout.
        if (strtolower(trim((string) $course->course_type)) !== 'paid') {
            return redirect()
                ->back()
                ->with('error', 'This course does not require payment.');
        }

        // Validate course price.
        $price = (float) $course->price;

        if ($price <= 0) {
            return redirect()
                ->back()
                ->with('error', 'The course price is invalid.');
        }

        // Prevent duplicate payment if student is already enrolled.
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if ($existingEnrollment) {
            return redirect()
                ->route('course.learn', $course->id)
                ->with('success', 'You are already enrolled in this course.');
        }

        // Check Razorpay configuration.
        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            Log::error('Razorpay credentials are missing.');

            return redirect()
                ->back()
                ->with('error', 'Payment gateway is not configured.');
        }

        try {
            $api = new Api($key, $secret);

            // Razorpay accepts amounts in paise.
            $amountInPaise = (int) round($price * 100);

            // Create Razorpay order on the server.
            $razorpayOrder = $api->order->create([
                'receipt' => 'course_' . $course->id
                    . '_user_' . $user->id
                    . '_' . uniqid(),
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'payment_capture' => 1,
                'notes' => [
                    'course_id' => (string) $course->id,
                    'user_id' => (string) $user->id,
                ],
            ]);

            // Save pending payment record.
            $coursePayment = CoursePayment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'gateway' => 'razorpay',
                'gateway_order_id' => $razorpayOrder['id'],
                'amount' => $price,
                'currency' => 'INR',
                'status' => 'pending',
            ]);

            return view('frontend.course-payment', [
                'course' => $course,
                'student' => $user,
                'coursePayment' => $coursePayment,
                'orderId' => $razorpayOrder['id'],
                'razorpayOrderId' => $razorpayOrder['id'], // Add this line
                'amount' => $amountInPaise,
                'razorpayKey' => $key,
            ]);
        } catch (Throwable $e) {
            Log::error('Razorpay checkout error', [
                'course_id' => $course->id,
                'user_id' => $user->id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Unable to start payment. Please try again.');
        }
    }

    /**
     * Verify Razorpay's payment signature and enroll the student.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:512'],
        ]);

        $user = Auth::user();

        $coursePayment = CoursePayment::where(
            'gateway_order_id',
            $request->razorpay_order_id
        )
            ->where('user_id', $user->id)
            ->where('gateway', 'razorpay')
            ->first();

        if (!$coursePayment) {
            return redirect()
                ->route('courses')
                ->with('error', 'Payment record not found.');
        }

        // Idempotency: don't process a payment already marked paid.
        if ($coursePayment->status === 'paid') {
            return redirect()
                ->route('my.learning')
                ->with('success', 'Payment was already verified. You are enrolled.');
        }

        $course = Course::find($coursePayment->course_id);

        if (!$course) {
            return redirect()
                ->route('courses')
                ->with('error', 'The course associated with this payment was not found.');
        }

        // Recheck that the course is paid.
        if (strtolower(trim((string) $course->course_type)) !== 'paid') {
            return redirect()
                ->route('courses')
                ->with('error', 'This course does not require payment.');
        }

        $key = config('services.razorpay.key');
        $secret = config('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            Log::error('Razorpay credentials are missing during verification.');

            return redirect()
                ->route('courses')
                ->with('error', 'Payment gateway is not configured.');
        }

        try {
            $api = new Api($key, $secret);

            // Verify the checkout signature.
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            // Fetch payment details directly from Razorpay.
            $gatewayPayment = $api->payment->fetch(
                $request->razorpay_payment_id
            );

            // Confirm that this payment belongs to the expected order.
            if ($gatewayPayment['order_id'] !== $coursePayment->gateway_order_id) {
                Log::warning('Razorpay order mismatch.', [
                    'payment_record_id' => $coursePayment->id,
                    'gateway_order_id' => $gatewayPayment['order_id'],
                ]);

                return redirect()
                    ->route('course.details', $course->id)
                    ->with('error', 'Payment verification failed.');
            }

            // Confirm amount and currency against the server-side record.
            $expectedAmount = (int) round((float) $coursePayment->amount * 100);

            if (
                (int) $gatewayPayment['amount'] !== $expectedAmount ||
                strtoupper((string) $gatewayPayment['currency']) !==
                strtoupper((string) $coursePayment->currency)
            ) {
                Log::warning('Razorpay amount or currency mismatch.', [
                    'payment_record_id' => $coursePayment->id,
                ]);

                return redirect()
                    ->route('course.details', $course->id)
                    ->with('error', 'Payment amount verification failed.');
            }

            // Only grant access after Razorpay reports the payment captured.
            if ($gatewayPayment['status'] !== 'captured') {
                return redirect()
                    ->route('course.details', $course->id)
                    ->with('error', 'Payment is not yet captured. Please check your payment status.');
            }

            // Save payment and enrollment atomically.
            DB::transaction(function () use (
                $coursePayment,
                $request,
                $user,
                $course
            ) {
                $lockedPayment = CoursePayment::whereKey($coursePayment->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Another request may already have processed this payment.
                if ($lockedPayment->status === 'paid') {
                    return;
                }

                $lockedPayment->update([
                    'gateway_payment_id' => $request->razorpay_payment_id,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                // Create enrollment only if one doesn't already exist.
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'status' => 'active',
                    ]
                );
            });

            return redirect()
                ->route('my.learning')
                ->with('success', 'Payment successful! You are now enrolled in the course.');
        } catch (Throwable $e) {
            Log::error('Razorpay payment verification error', [
                'user_id' => $user->id,
                'order_id' => $request->razorpay_order_id,
                'payment_id' => $request->razorpay_payment_id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('course.details', $course->id)
                ->with('error', 'Payment could not be verified. If money was deducted, please check your payment status before retrying.');
        }
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        $coursePayment = CoursePayment::where('gateway_order_id', $request->razorpay_order_id)
            ->where('user_id', $user->id)
            ->where('gateway', 'razorpay')
            ->where('status', 'pending')
            ->first();

        if ($coursePayment) {
            $coursePayment->update([
                'status' => 'cancelled',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment cancelled.',
        ]);
    }

    public function failed(Request $request)
{
    $request->validate([
        'razorpay_order_id' => ['required', 'string', 'max:255'],
    ]);

    $user = Auth::user();

    $coursePayment = CoursePayment::where(
            'gateway_order_id',
            $request->razorpay_order_id
        )
        ->where('user_id', $user->id)
        ->where('gateway', 'razorpay')
        ->where('status', 'pending')
        ->first();

    if ($coursePayment) {
        $coursePayment->update([
            'status' => 'failed',
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Payment failed.',
    ]);
}
}
