@extends('frontend.master')

@section('title', 'Courses | Student LMS')

@section('content')

<section class="page-hero text-white py-5">
    <div class="container py-5 hero-content">
        <div class="text-center">
            <span class="stat-pill mb-3">
                <i class="fa-solid fa-book-open"></i>
                Browse all courses
            </span>
            <h1 class="display-5 fw-black mb-3">Explore Our Courses</h1>
            <p class="lead text-white-50 mx-auto mb-0" style="max-width: 700px;">
                Find the right course for your goals and start learning with confidence.
            </p>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Categories</h5>

                        <a href="{{ route('courses') }}" class="d-block text-decoration-none px-3 py-2 rounded-3 mb-2 text-dark fw-semibold bg-primary-subtle">
                            All Courses
                        </a>

                        @foreach($categories as $category)
                            <a href="#" class="d-flex justify-content-between align-items-center text-decoration-none px-3 py-2 rounded-3 mb-2 text-dark bg-light">
                                <span>{{ $category->name }}</span>
                                <span class="badge bg-white text-dark border">{{ $category->courses_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($courses as $course)
                        <div class="col-md-6 col-xl-4">
                            <div class="course-card shadow-sm">
                                @if($course->image)
                                    <img src="{{ asset('uploads/courses/' . $course->image) }}" class="course-image" alt="{{ $course->title }}">
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <small class="text-muted mb-2">{{ $course->category->name }}</small>
                                    <h5 class="fw-bold mt-1">{{ $course->title }}</h5>
                                    <p class="text-muted small mb-3">{{ Str::limit($course->description, 90) }}</p>

                                    <div class="mt-auto">
                                        <div class="mb-3">
                                            @if($course->course_type === 'free')
                                                <span class="text-success fw-bold">Free Course</span>
                                            @else
                                                <span class="fw-bold">₹{{ number_format($course->price, 2) }}</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('course.details', $course->id) }}" class="btn btn-primary w-100">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">No courses available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase text-primary fw-semibold small mb-2">Your learning path</p>
            <h2 class="fw-bold mb-2">Build momentum with every lesson</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h5 class="fw-bold">Expert guidance</h5>
                    <p class="text-muted mb-0">Access structured learning designed to help you move from beginner to confident practitioner.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h5 class="fw-bold">Real outcomes</h5>
                    <p class="text-muted mb-0">Gain practical knowledge and skills that support your long-term growth and career direction.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h5 class="fw-bold">Flexible pace</h5>
                    <p class="text-muted mb-0">Learn on your schedule with self-paced lessons built around your time and goals.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection