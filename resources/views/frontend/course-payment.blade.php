@extends('frontend.master')

@section('title', 'Course Payment')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="bg-primary text-white text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid fa-graduation-cap fa-3x"></i>
                    </div>
                    <h2 class="fw-bold mb-1">Complete Your Payment</h2>
                    <p class="mb-0">Securely enroll in your selected course</p>
                </div>

                <div class="card-body p-4 p-md-5">

                    {{-- Course Summary --}}
                    <h5 class="fw-bold mb-3">Course Summary</h5>

                    <div class="border rounded-3 p-3 mb-4 bg-light">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h5 class="fw-bold mb-2">
                                    {{ $course->title }}
                                </h5>

                                <p class="text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit($course->description ?? '', 120) }}
                                </p>
                            </div>

                            <span class="badge bg-primary">Paid Course</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Student</span>
                            <span class="fw-semibold">
                                {{ $student->name }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Email</span>
                            <span class="fw-semibold text-break">
                                {{ $student->email }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Amount</span>
                            <span class="fs-3 fw-bold text-success">
                                ₹{{ number_format((float) $coursePayment->amount, 2) }}
                            </span>
                        </div>
                    </div>

                    {{-- Security Information --}}
                    <div class="alert alert-info">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-shield-halved mt-1"></i>
                            <div>
                                <strong>Secure Payment</strong>
                                <p class="small mb-0">
                                    Your payment will be processed securely
                                    through Razorpay. Course access is granted
                                    after payment verification.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Error --}}
                    <div id="payment-error"
                        class="alert alert-danger d-none"
                        role="alert">
                    </div>

                    {{-- Payment Configuration --}}
                    <div id="payment-config"
                        data-key="{{ $razorpayKey }}"
                        data-order-id="{{ $orderId }}"
                        data-amount="{{ (int) $amount }}"
                        data-course-title="{{ $course->title }}"
                        data-student-name="{{ $student->name }}"
                        data-student-email="{{ $student->email }}"
                        data-payment-amount="{{ number_format((float) $coursePayment->amount, 2, '.', '') }}">
                    </div>

                    {{-- Pay Button --}}
                    <button type="button"
                        id="pay-button"
                        class="btn btn-primary btn-lg w-100 py-3">
                        <i class="fa-solid fa-lock me-2"></i>
                        Pay ₹{{ number_format((float) $coursePayment->amount, 2) }}
                    </button>

                    {{-- Back Button --}}
                    <a href="{{ route('course.details', $course->id) }}"
                        class="btn btn-outline-secondary w-100 mt-3 py-2">
                        <i class="fa-solid fa-arrow-left me-2"></i>
                        Back to Course
                    </a>

                    {{-- Payment Verification Form --}}
                    <form id="verification-form"
                        action="{{ route('course.payment.verify') }}"
                        method="POST"
                        class="d-none">
                        @csrf

                        <input type="hidden"
                            name="razorpay_payment_id"
                            id="razorpay_payment_id">

                        <input type="hidden"
                            name="razorpay_order_id"
                            id="razorpay_order_id">

                        <input type="hidden"
                            name="razorpay_signature"
                            id="razorpay_signature">
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fa-solid fa-lock me-1"></i>
                            Secure checkout powered by Razorpay
                        </small>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Razorpay Checkout SDK --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const config = document.getElementById('payment-config');
        const payButton = document.getElementById('pay-button');
        const errorBox = document.getElementById('payment-error');
        const verificationForm = document.getElementById('verification-form');

        if (!config || !payButton || !errorBox || !verificationForm) {
            return;
        }

        // Read configuration from HTML data attributes.
        const razorpayKey = config.dataset.key;
        const razorpayOrderId = config.dataset.orderId;
        const amountInPaise = Number(config.dataset.amount);
        const courseTitle = config.dataset.courseTitle;
        const studentName = config.dataset.studentName;
        const studentEmail = config.dataset.studentEmail;
        const paymentAmount = config.dataset.paymentAmount;

        function showError(message) {
            errorBox.textContent = message;
            errorBox.classList.remove('d-none');
        }

        function resetPayButton() {
            payButton.disabled = false;
            payButton.innerHTML =
                '<i class="fa-solid fa-lock me-2"></i>Pay ₹' + paymentAmount;
        }

        payButton.addEventListener('click', function() {
            errorBox.textContent = '';
            errorBox.classList.add('d-none');

            if (typeof Razorpay === 'undefined') {
                showError(
                    'Razorpay could not be loaded. Check your internet connection and try again.'
                );
                return;
            }

            if (!razorpayKey || !razorpayOrderId ||
                !Number.isFinite(amountInPaise) || amountInPaise <= 0) {
                showError(
                    'Payment configuration is incomplete. Please contact the administrator.'
                );
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>' +
                'Opening secure checkout...';

            const options = {
                key: razorpayKey,
                amount: amountInPaise,
                currency: 'INR',
                name: 'StudentLMS',
                description: courseTitle,
                order_id: razorpayOrderId,

                prefill: {
                    name: studentName,
                    email: studentEmail
                },

                theme: {
                    color: '#0d6efd'
                },

                handler: function(response) {
                    document.getElementById('razorpay_payment_id').value =
                        response.razorpay_payment_id;

                    document.getElementById('razorpay_order_id').value =
                        response.razorpay_order_id;

                    document.getElementById('razorpay_signature').value =
                        response.razorpay_signature;

                    payButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span>' +
                        'Verifying payment...';

                    verificationForm.submit();
                },

                modal: {
                    ondismiss: function() {

                        fetch("{{ route('course.payment.cancel') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    razorpay_order_id: razorpayOrderId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                resetPayButton();

                                if (data.success) {
                                    showError('Payment cancelled. You can try again.');
                                }
                            })
                            .catch(error => {
                                console.error('Cancel request failed:', error);
                                resetPayButton();
                            });
                    }
                }
            };

            try {
                const razorpay = new Razorpay(options);

                razorpay.on('payment.failed', function(response) {

                    fetch("{{ route('course.payment.failed') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                razorpay_order_id: razorpayOrderId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            showError(
                                'Payment failed. Please try again.'
                            );

                            resetPayButton();

                        })
                        .catch(error => {

                            console.error('Failed payment update error:', error);

                            showError(
                                'Payment failed. Please try again.'
                            );

                            resetPayButton();
                        });
                });

                razorpay.open();

            } catch (error) {
                showError(
                    'Unable to open the payment window. Please try again.'
                );
                resetPayButton();
            }
        });
    });
</script>

@endsection