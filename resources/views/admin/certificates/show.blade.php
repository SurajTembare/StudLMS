@extends('admin.master')

@section('title', 'Certificate Details')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-certificate text-warning me-2"></i>
                Certificate Details
            </h3>

            <p class="text-muted mb-0">
                View certificate and student information.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.certificates.index') }}"
                class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>

            <a
                href="{{ route('admin.certificates.download', $certificate->id) }}"
                class="btn btn-success">
                <i class="fas fa-download me-1"></i>
                Download PDF
            </a>

        </div>

    </div>


    <div class="row g-4">

        {{-- Certificate Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-award text-warning me-2"></i>
                        Certificate Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        {{-- Certificate Number --}}
                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    Certificate Number
                                </small>

                                <div class="fw-bold">
                                    <i class="fas fa-certificate text-warning me-2"></i>

                                    {{ $certificate->certificate_number }}
                                </div>

                            </div>

                        </div>


                        {{-- Issued Date --}}
                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    Issued Date
                                </small>

                                <div class="fw-bold">

                                    @if($certificate->issued_at)

                                    {{ $certificate->issued_at->format('d M Y') }}

                                    <small class="text-muted">
                                        {{ $certificate->issued_at->format('h:i A') }}
                                    </small>

                                    @else

                                    —

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Course --}}
                        <div class="col-12">

                            <div class="border rounded p-3">

                                <small class="text-muted d-block mb-1">
                                    Course
                                </small>

                                @if($certificate->course)

                                <h5 class="fw-bold mb-1">
                                    {{ $certificate->course->title }}
                                </h5>

                                @if($certificate->course->description)

                                <p class="text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit(
                                     $certificate->course->description,
                                     250) }}

                                </p>

                                @endif

                                @else

                                <span class="text-muted">
                                    Course unavailable
                                </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Student Information --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-graduate text-primary me-2"></i>
                        Student Information
                    </h5>

                </div>

                <div class="card-body">

                    @if($certificate->user)

                    <div class="d-flex align-items-center">

                        <div
                            class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                            style="width:65px;height:65px;font-size:24px;">
                            {{ strtoupper(
                                    substr($certificate->user->name, 0, 1)
                                ) }}
                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                {{ $certificate->user->name }}
                            </h5>

                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-2"></i>
                                {{ $certificate->user->email }}
                            </p>

                            @if($certificate->user->phone)

                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-2"></i>
                                {{ $certificate->user->phone }}
                            </p>

                            @endif

                        </div>

                    </div>

                    @else

                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Student information is unavailable.
                    </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- Right Side --}}
        <div class="col-lg-4">

            {{-- Status Card --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-4">

                    <div
                        class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                        style="
                            width:90px;
                            height:90px;
                            border-radius:50%;
                            background:#fff8e1;
                        ">

                        <i
                            class="fas fa-certificate text-warning"
                            style="font-size:42px;"></i>

                    </div>

                    <h5 class="fw-bold">
                        Certificate Issued
                    </h5>

                    <p class="text-muted mb-0">
                        This certificate was issued to the student
                        after completing the course.
                    </p>

                </div>

            </div>


            {{-- Actions --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-header bg-white py-3">

                    <h6 class="mb-0 fw-bold">
                        Actions
                    </h6>

                </div>

                <div class="card-body">

                    <a
                        href="{{ route('admin.certificates.download', $certificate->id) }}"
                        class="btn btn-success w-100 mb-2">
                        <i class="fas fa-download me-2"></i>
                        Download Certificate
                    </a>


                    <form
                        action="{{ route('admin.certificates.destroy', $certificate->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this certificate?');">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            Delete Certificate
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection