@extends('admin.master')

@section('title', 'Payment Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-receipt me-2"></i>
                Payment Details
            </h2>

            <p class="text-muted mb-0">
                Payment #{{ $payment->id }}
            </p>

        </div>


        <a href="{{ route('admin.payments.index') }}"
           class="btn btn-outline-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>
            Back to Payments

        </a>

    </div>


    <div class="row g-4">

        {{-- Payment Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        Payment Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">

                        {{-- Payment ID --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Razorpay Payment ID
                            </small>

                            <strong class="text-break">
                                {{ $payment->gateway_payment_id ?? 'Not available' }}
                            </strong>

                        </div>


                        {{-- Order ID --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Razorpay Order ID
                            </small>

                            <strong class="text-break">
                                {{ $payment->gateway_order_id }}
                            </strong>

                        </div>


                        {{-- Gateway --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Payment Gateway
                            </small>

                            <strong>
                                {{ ucfirst($payment->gateway) }}
                            </strong>

                        </div>


                        {{-- Currency --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Currency
                            </small>

                            <strong>
                                {{ $payment->currency }}
                            </strong>

                        </div>


                        {{-- Amount --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Amount
                            </small>

                            <strong class="fs-4 text-success">
                                ₹{{ number_format((float) $payment->amount, 2) }}
                            </strong>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block mb-1">
                                Status
                            </small>


                            @if($payment->status === 'paid')

                                <span class="badge bg-success fs-6">
                                    Paid
                                </span>

                            @elseif($payment->status === 'pending')

                                <span class="badge bg-warning text-dark fs-6">
                                    Pending
                                </span>

                            @elseif($payment->status === 'failed')

                                <span class="badge bg-danger fs-6">
                                    Failed
                                </span>

                            @elseif($payment->status === 'cancelled')

                                <span class="badge bg-secondary fs-6">
                                    Cancelled
                                </span>

                            @else

                                <span class="badge bg-dark fs-6">
                                    {{ ucfirst($payment->status) }}
                                </span>

                            @endif

                        </div>


                        {{-- Created --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Created At
                            </small>

                            <strong>
                                {{ $payment->created_at?->format('d M Y, h:i A') }}
                            </strong>

                        </div>


                        {{-- Paid At --}}
                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Paid At
                            </small>

                            <strong>

                                @if($payment->paid_at)

                                    {{ $payment->paid_at->format('d M Y, h:i A') }}

                                @else

                                    —

                                @endif

                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Student & Course --}}
        <div class="col-lg-4">

            {{-- Student --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-user me-2"></i>
                        Student
                    </h5>

                </div>


                <div class="card-body">

                    <h5 class="fw-bold">

                        {{ $payment->user->name ?? 'N/A' }}

                    </h5>

                    <p class="text-muted mb-0">

                        {{ $payment->user->email ?? 'N/A' }}

                    </p>

                </div>

            </div>


            {{-- Course --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-book me-2"></i>
                        Course
                    </h5>

                </div>


                <div class="card-body">

                    <h5 class="fw-bold">

                        {{ $payment->course->title ?? 'N/A' }}

                    </h5>

                    <a href="{{ route('course.details', $payment->course_id) }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary mt-2">

                        View Course

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection