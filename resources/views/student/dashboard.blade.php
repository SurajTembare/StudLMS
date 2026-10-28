@extends('frontend.master')

@section('title', 'Student Dashboard')

@section('content')

<div class="container py-5">

    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-2">
                Welcome, {{ auth()->user()->name }}!
            </h2>
            <p class="text-muted mb-0">
                Welcome to your learning dashboard.
            </p>
        </div>

        <a href="{{ route('courses') }}" class="btn btn-primary">
            <i class="fa-solid fa-book-open me-2"></i>
            Explore Courses
        </a>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">

        {{-- Total Enrollments --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-book-open fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Enrollments</h6>
                        <h2 class="fw-bold mb-0">{{ $totalEnrollments }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Courses --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-play-circle fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Active Courses</h6>
                        <h2 class="fw-bold mb-0">{{ $activeCourses }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Completed Courses --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Completed Courses</h6>
                        <h2 class="fw-bold mb-0">{{ $completedCourses }}</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Recent Enrollments --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>
                    Recent Enrollments
                </h5>

                <a href="{{ route('my.learning') }}"
                    class="btn btn-outline-primary btn-sm">
                    View My Learning
                </a>
            </div>
        </div>

        <div class="card-body p-4">

            @forelse ($recentEnrollments as $enrollment)

            @php
            $progress = (int) ($enrollment->progress_percentage ?? 0);
            $progress = max(0, min(100, $progress));
            @endphp

            <div class="border-bottom py-4">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                    {{-- Course Information --}}
                    <div class="flex-grow-1">

                        <h6 class="fw-bold mb-2">
                            {{ $enrollment->course
                                    ? $enrollment->course->title
                                    : 'Course unavailable' }}
                        </h6>

                        {{-- Enrollment Status --}}
                        <div class="mb-3">

                            @if ($enrollment->status === 'completed')
                            <span class="badge bg-success">
                                <i class="fa-solid fa-check-circle me-1"></i>
                                Completed
                            </span>
                            @elseif ($enrollment->status === 'active')
                            <span class="badge bg-primary">
                                <i class="fa-solid fa-book-open me-1"></i>
                                Active
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                {{ ucfirst($enrollment->status ?? 'Unknown') }}
                            </span>
                            @endif

                        </div>


                        {{-- Learning Progress --}}
                        <div style="max-width: 450px;">

                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">
                                    Learning Progress
                                </small>

                                <small class="fw-bold">
                                    {{ $progress }}%
                                </small>
                            </div>

                            {{-- Progress Track --}}
                            <div style="height: 12px;
                             width: 100%;
                              background-color: #e9ecef;
                              border-radius: 20px;
                              overflow: hidden;">

                                {{-- Progress Bar --}}
                                <div class="student-progress-track">
                                    <div
                                        class="student-progress-fill"
                                        data-progress="{{ $progress }}">
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Course Action --}}
                    <div>

                        @if ($enrollment->status === 'completed')
                        <a href="{{ route('my.learning') }}"
                            class="btn btn-outline-success btn-sm">
                            <i class="fa-solid fa-eye me-1"></i>
                            View Course
                        </a>
                        @else
                        <a href="{{ route('my.learning') }}"
                            class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-play me-1"></i>
                            Continue Learning
                        </a>
                        @endif

                    </div>

                </div>

            </div>

            @empty

            {{-- Empty State --}}
            <div class="text-center py-5">
                <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>

                <h5 class="fw-bold">No Courses Yet</h5>

                <p class="text-muted">
                    You have not enrolled in any courses yet.
                    Explore our courses and start learning.
                </p>

                <a href="{{ route('courses') }}" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                    Explore Courses
                </a>
            </div>

            @endforelse

        </div>
    </div>

    {{-- Quick Links --}}
    <div class="mt-4">

        <h5 class="fw-bold mb-3">Quick Links</h5>

        <div class="d-flex flex-wrap gap-2">

            <a href="{{ route('my.learning') }}"
                class="btn btn-outline-primary">
                <i class="fa-solid fa-book-open me-2"></i>
                My Learning
            </a>

            <a href="{{ route('student.certificates.index') }}"
                class="btn btn-outline-success">
                <i class="fa-solid fa-certificate me-2"></i>
                My Certificates
            </a>

            <a href="{{ route('profile.edit') }}"
                class="btn btn-outline-secondary">
                <i class="fa-solid fa-user-pen me-2"></i>
                Edit Profile
            </a>

        </div>

    </div>

</div>

<style>
    .student-progress-track {
        width: 100%;
        height: 12px;
        background-color: #e9ecef;
        border-radius: 20px;
        overflow: hidden;
    }

    .student-progress-fill {
        height: 100%;
        width: 0;
        background-color: #0d6efd;
        border-radius: 20px;
        transition: width 0.4s ease;
    }
</style>

<script>
    document.querySelectorAll('.student-progress-fill').forEach(function (bar) {
        let progress = Number(bar.dataset.progress);

        progress = Math.max(0, Math.min(100, progress));

        bar.style.width = progress + '%';
    });
</script>

@endsection