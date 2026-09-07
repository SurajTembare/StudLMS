@extends('frontend.master')

@section('title', 'Home | Student LMS')

@section('content')

<section class="page-hero text-white py-5">
    <div class="container py-5 hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="mb-4">
                    <span class="stat-pill">
                        <i class="fa-solid fa-sparkles"></i>
                        Learn smarter. Grow faster.
                    </span>
                </div>

                <h1 class="display-4 fw-black lh-sm mb-3">
                    Learn Skills. Build Your Future.
                </h1>

                <p class="lead text-white-50 mb-4" style="max-width: 650px;">
                    Explore practical courses, sharpen your expertise, and move forward with confidence through a modern learning experience built for real results.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('courses') }}" class="btn btn-light btn-lg px-4 py-3 fw-semibold">
                        Explore Courses
                        <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold">
                        Join Now
                    </a>
                </div>

                <div class="d-flex flex-wrap gap-4 text-white-50 small">
                    <span><i class="fa-solid fa-check me-2 text-success"></i> 120+ expert-led courses</span>
                    <span><i class="fa-solid fa-check me-2 text-success"></i> 5K+ active learners</span>
                    <span><i class="fa-solid fa-check me-2 text-success"></i> Career-focused learning</span>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="float-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <p class="text-white-50 mb-1 small text-uppercase tracking">Trending now</p>
                            <h5 class="fw-bold text-white mb-0">Career Growth</h5>
                        </div>
                        <div class="rounded-circle bg-white/10 p-3">
                            <i class="fa-solid fa-chart-line text-white"></i>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-white/10 border border-white/10">
                                <div class="text-white-50 small">Courses</div>
                                <div class="display-6 fw-bold text-white">120+</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-4 bg-white/10 border border-white/10">
                                <div class="text-white-50 small">Students</div>
                                <div class="display-6 fw-bold text-white">5k+</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 rounded-4 bg-success-subtle border border-success/30 text-success-emphasis">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">Learning success</span>
                                    <span class="badge bg-success text-white">96%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase text-primary fw-semibold small mb-2">Explore categories</p>
            <h2 class="fw-bold mb-2">Choose what you want to learn</h2>
            <p class="text-muted mx-auto mb-0" style="max-width: 620px;">
                Discover the subjects that match your goals and start building your future with confidence.
            </p>
        </div>

        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden">
                        @if($category->image)
                            <img src="{{ asset('uploads/categories/' . $category->image) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $category->name }}">
                        @endif

                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                            <p class="text-muted mb-0">
                                {{ $category->courses_count }} Courses
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No categories available.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <p class="text-uppercase text-primary fw-semibold small mb-2">Latest courses</p>
                <h2 class="fw-bold mb-0">Continue learning with the best picks</h2>
            </div>

            <a href="{{ route('courses') }}" class="btn btn-outline-primary px-4">
                View All
            </a>
        </div>

        <div class="row g-4">
            @forelse($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="course-card shadow-sm">
                        @if($course->image)
                            <img src="{{ asset('uploads/courses/' . $course->image) }}" class="course-image" alt="{{ $course->title }}">
                        @else
                            <div class="course-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-book fa-3x text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <span class="course-badge align-self-start mb-2">
                                {{ $course->category->name }}
                            </span>

                            <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                            <p class="text-muted small mb-3">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                @if($course->course_type === 'free')
                                    <span class="text-success fw-bold">Free</span>
                                @else
                                    <span class="fw-bold">₹{{ number_format($course->price, 2) }}</span>
                                @endif

                                <a href="{{ route('course.details', $course->id) }}" class="btn btn-primary btn-sm">
                                    View Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">No courses available yet.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase text-primary fw-semibold small mb-2">Why learners choose us</p>
            <h2 class="fw-bold mb-2">A platform built for real growth</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h5 class="fw-bold">Structured learning</h5>
                    <p class="text-muted mb-0">Follow clear, guided paths designed to help you master each skill step by step.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h5 class="fw-bold">Career focus</h5>
                    <p class="text-muted mb-0">Learn the skills employers and modern teams need to stay relevant and competitive.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 h-100 p-4 shadow-sm">
                    <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h5 class="fw-bold">Progress tracking</h5>
                    <p class="text-muted mb-0">Stay motivated with a smooth learning flow and measurable progress across every course.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection