@extends('frontend.master')

@section('title', 'My Certificates')

@section('content')

<div class="container py-5">

    <div class="mb-5">

        <h2 class="fw-bold">
            My Certificates
        </h2>

        <p class="text-muted">
            View certificates earned from completed courses.
        </p>

    </div>


    @if($certificates->count() > 0)

        <div class="row g-4">

            @foreach($certificates as $certificate)

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm">

                        <div
                            class="card-body text-center p-4">

                            <i
                                class="fa-solid fa-award fa-4x text-warning mb-3">
                            </i>


                            <h5 class="fw-bold">

                                {{ $certificate->course->title }}

                            </h5>


                            <p class="text-muted small">

                                Certificate No:

                                {{ $certificate->certificate_number }}

                            </p>


                            <p class="text-muted small">

                                Issued:

                                {{ $certificate->issued_at->format('d M Y') }}

                            </p>


                            <a
                                href="{{ route(
                                    'student.certificate.show',
                                    $certificate->id
                                ) }}"
                                class="btn btn-primary w-100">

                                <i class="fa-solid fa-eye me-2"></i>

                                View Certificate

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="text-center py-5">

            <i
                class="fa-solid fa-certificate fa-4x text-muted mb-3">
            </i>

            <h4>
                No Certificates Yet
            </h4>

            <p class="text-muted">

                Complete a course to earn your certificate.

            </p>

        </div>

    @endif

</div>

@endsection