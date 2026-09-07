@extends('frontend.master')

@section('title', $course->title . ' | Student LMS')

@section('content')

<section class="page-hero text-white py-5">
    <div class="container py-5 hero-content">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="course-badge bg-white text-primary mb-3">
                    {{ $course->category->name }}
                </span>

                <h1 class="display-5 fw-black mb-3">{{ $course->title }}</h1>
                <p class="lead text-white-50 mb-4">{{ $course->description }}</p>

                <div class="d-flex flex-wrap gap-3">
                    <div class="stat-pill">
                        <i class="fa-solid fa-clock"></i>
                        Self-paced learning
                    </div>
                    <div class="stat-pill">
                        <i class="fa-solid fa-certificate"></i>
                        Beginner to advanced
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 overflow-hidden shadow-lg">
                    @if($course->image)
                        <img src="{{ asset('uploads/courses/' . $course->image) }}" class="img-fluid w-100" style="height: 360px; object-fit: cover;" alt="{{ $course->title }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 360px;">
                            <i class="fa-solid fa-book fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 p-4 p-md-5 shadow-sm">
                    <h3 class="fw-bold mb-4">Course Content</h3>

                    <div class="d-grid gap-3">
                        @forelse($course->lectures as $lecture)
                            <div class="lecture-item d-flex align-items-start">
                                <div class="me-3 mt-1 d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary" style="width: 40px; height: 40px;">
                                    <i class="fa-solid fa-play"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-1">
                                        {{ $lecture->lecture_order }}. {{ $lecture->title }}
                                    </div>
                                    @if($lecture->description)
                                        <div class="small text-muted">
                                            {{ Str::limit($lecture->description, 90) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No lectures have been added yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4">
                    <div class="mb-3">
                        <p class="text-muted mb-1">Course Price</p>
                        @if($course->course_type === 'free')
                            <h3 class="text-success fw-bold mb-0">Free Course</h3>
                        @else
                            <h3 class="fw-bold mb-0">₹{{ number_format($course->price, 2) }}</h3>
                        @endif
                    </div>

                    <p class="text-muted small mb-4">
                        Enroll now to access all lessons and continue your learning path.
                    </p>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>
                            Login to Enroll
                        </a>
                    @endguest

                    @auth
                        @if($isEnrolled)
                            <a href="{{ route('course.learn', $course->id) }}" class="btn btn-success w-100">
                                <i class="fa-solid fa-play me-2"></i>
                                Continue Learning
                            </a>

                            <p class="text-success text-center small mt-3 mb-0">
                                <i class="fa-solid fa-circle-check me-1"></i>
                                You are already enrolled!
                            </p>
                        @else
                            <form action="{{ route('course.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-graduation-cap me-2"></i>
                                    Enroll Now
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@endsection