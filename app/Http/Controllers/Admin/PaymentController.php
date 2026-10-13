<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursePayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display all payments.
     */
    public function index(Request $request)
    {
        $query = CoursePayment::with(['user', 'course'])
            ->latest();

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('gateway_order_id', 'like', "%{$search}%")
                    ->orWhere('gateway_payment_id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")

                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })

                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }


    /**
     * Display payment details.
     */
    public function show($id)
    {
        $payment = CoursePayment::with(['user', 'course'])
            ->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }
}