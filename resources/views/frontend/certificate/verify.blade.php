@extends('frontend.master')

@section('title', 'Verify Certificate')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-6">

            <div class="text-center mb-4">

                <i class="fa-solid fa-certificate fa-4x text-primary mb-3"></i>

                <h2 class="fw-bold">
                    Verify Certificate
                </h2>

                <p class="text-muted">
                    Enter the certificate number to verify its authenticity.
                </p>

            </div>


            {{-- Verification Form --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="{{ route('certificate.verify') }}"
                        method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Certificate Number
                            </label>

                            <input
                                type="text"
                                name="certificate_number"
                                class="form-control @error('certificate_number') is-invalid @enderror"
                                placeholder="Example: CERT-ABC123XYZ"
                                value="{{ old('certificate_number') }}"
                                required>

                            @error('certificate_number')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="fa-solid fa-magnifying-glass me-2"></i>

                            Verify Certificate

                        </button>

                    </form>

                </div>

            </div>


            {{-- Certificate Result --}}
            @if(isset($certificate))

                @if($certificate)

                <div class="card border-success shadow-sm mt-4">

                    <div class="card-body text-center p-4">

                        <i class="fa-solid fa-circle-check fa-4x text-success mb-3"></i>

                        <h4 class="fw-bold text-success">
                            Valid Certificate
                        </h4>

                        <p class="text-muted">
                            This certificate has been successfully verified.
                        </p>


                        <hr>


                        <div class="text-start">

                            <p>
                                <strong>Student Name:</strong>

                                {{ $certificate->user->name }}
                            </p>


                            <p>
                                <strong>Course:</strong>

                                {{ $certificate->course->title }}
                            </p>


                            <p>
                                <strong>Certificate Number:</strong>

                                {{ $certificate->certificate_number }}
                            </p>


                            <p class="mb-0">
                                <strong>Issued Date:</strong>

                                {{ $certificate->issued_at->format('d M Y') }}
                            </p>

                        </div>

                    </div>

                </div>

                @else

                <div class="card border-danger shadow-sm mt-4">

                    <div class="card-body text-center p-4">

                        <i class="fa-solid fa-circle-xmark fa-4x text-danger mb-3"></i>

                        <h4 class="fw-bold text-danger">
                            Certificate Not Found
                        </h4>

                        <p class="text-muted mb-0">
                            The certificate number you entered could not be verified.
                            Please check the number and try again.
                        </p>

                    </div>

                </div>

                @endif

            @endif

        </div>

    </div>

</div>

@endsection