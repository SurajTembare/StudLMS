@extends('admin.master')

@section('title', 'Payments')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-credit-card me-2"></i>
                Payments
            </h2>

            <p class="text-muted mb-0">
                Manage course payments
            </p>
        </div>

    </div>


    {{-- Search & Filter --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.payments.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Student, email, course, payment ID..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                All Status
                            </option>

                            <option value="paid"
                                {{ request('status') === 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="pending"
                                {{ request('status') === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="failed"
                                {{ request('status') === 'failed' ? 'selected' : '' }}>
                                Failed
                            </option>

                            <option value="cancelled"
                                {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-3 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fa-solid fa-filter me-1"></i>
                            Filter

                        </button>

                        <a href="{{ route('admin.payments.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="fa-solid fa-rotate-left"></i>

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Payment Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Student</th>

                            <th>Course</th>

                            <th>Amount</th>

                            <th>Payment ID</th>

                            <th>Order ID</th>

                            <th>Status</th>

                            <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($payments as $payment)

                            <tr>

                                {{-- ID --}}
                                <td>
                                    {{ $payment->id }}
                                </td>


                                {{-- Student --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $payment->user->name ?? 'N/A' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $payment->user->email ?? '' }}
                                    </small>

                                </td>


                                {{-- Course --}}
                                <td>

                                    {{ $payment->course->title ?? 'N/A' }}

                                </td>


                                {{-- Amount --}}
                                <td>

                                    <strong>
                                        ₹{{ number_format((float) $payment->amount, 2) }}
                                    </strong>

                                </td>


                                {{-- Payment ID --}}
                                <td>

                                    @if($payment->gateway_payment_id)

                                        <small class="text-muted">
                                            {{ $payment->gateway_payment_id }}
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Order ID --}}
                                <td>

                                    <small class="text-muted">
                                        {{ $payment->gateway_order_id }}
                                    </small>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($payment->status === 'paid')

                                        <span class="badge bg-success">
                                            Paid
                                        </span>

                                    @elseif($payment->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif($payment->status === 'failed')

                                        <span class="badge bg-danger">
                                            Failed
                                        </span>

                                    @elseif($payment->status === 'cancelled')

                                        <span class="badge bg-secondary">
                                            Cancelled
                                        </span>

                                    @else

                                        <span class="badge bg-dark">
                                            {{ ucfirst($payment->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td>

                                    <small>
                                        {{ $payment->created_at?->format('d M Y, h:i A') }}
                                    </small>

                                </td>


                                {{-- Action --}}
                                <td>

                                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center py-5">

                                    <i class="fa-solid fa-credit-card fa-2x text-muted mb-3"></i>

                                    <p class="text-muted mb-0">
                                        No payments found.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Pagination --}}
        @if($payments->hasPages())

            <div class="card-footer bg-white">

                {{ $payments->links() }}

            </div>

        @endif

    </div>

</div>

@endsection