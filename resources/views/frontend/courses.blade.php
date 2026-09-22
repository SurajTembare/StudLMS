@extends('frontend.master')

@section('title', 'Courses | Student LMS')

@section('content')

{{-- =========================================================
     HERO SECTION
========================================================= --}}
<section class="page-hero text-white py-5">

    <div class="container py-5 hero-content">

        <div class="text-center">

            <span class="stat-pill mb-3">
                <i class="fa-solid fa-book-open"></i>
                Browse all courses
            </span>

            <h1 class="display-5 fw-black mb-3">
                Explore Our Courses
            </h1>

            <p class="lead text-white-50 mx-auto mb-0"
                style="max-width: 700px;">

                Find the right course for your goals and start learning
                with confidence.

            </p>

        </div>

    </div>

</section>


{{-- =========================================================
     COURSES SECTION
========================================================= --}}
<section class="py-5">

    <div class="container">

        <div class="row">


            {{-- =================================================
                 LEFT SIDEBAR
            ================================================= --}}
            <div class="col-lg-3 mb-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        {{-- =====================================
                             CATEGORIES
                        ====================================== --}}
                        <h5 class="fw-bold mb-3">
                            Categories
                        </h5>


                        {{-- ALL COURSES --}}
                        <a
                            href="{{ route('courses', [
                                'search' => request('search'),
                                'course_type' => request('course_type')
                            ]) }}"
                            class="d-block text-decoration-none px-3 py-2 rounded-3 mb-2 fw-semibold
                            {{ !request('category_id')
                                ? 'bg-primary text-white'
                                : 'text-dark bg-light' }}">

                            <i class="fa-solid fa-layer-group me-1"></i>

                            All Courses

                        </a>


                        {{-- CATEGORY LIST --}}
                        @foreach($categories as $category)

                        <a
                            href="{{ route('courses', [
                                    'category_id' => $category->id,
                                    'search' => request('search'),
                                    'course_type' => request('course_type')
                                ]) }}"
                            class="d-flex justify-content-between align-items-center
                                text-decoration-none px-3 py-2 rounded-3 mb-2
                                {{ request('category_id') == $category->id
                                    ? 'bg-primary text-white'
                                    : 'text-dark bg-light' }}">

                            <span>
                                {{ $category->name }}
                            </span>


                            <span
                                class="badge border
                                    {{ request('category_id') == $category->id
                                        ? 'bg-white text-primary'
                                        : 'bg-white text-dark' }}">

                                {{ $category->courses_count }}

                            </span>

                        </a>

                        @endforeach


                        <hr class="my-4">


                        {{-- =====================================
                             COURSE TYPE
                        ====================================== --}}
                        <h5 class="fw-bold mb-3">
                            Course Type
                        </h5>


                        {{-- ALL TYPES --}}
                        <a
                            href="{{ route('courses', [
                                'category_id' => request('category_id'),
                                'search' => request('search')
                            ]) }}"
                            class="d-flex align-items-center text-decoration-none
                            px-3 py-2 rounded-3 mb-2
                            {{ !request('course_type')
                                ? 'bg-primary text-white'
                                : 'text-dark bg-light' }}">

                            <i class="fa-solid fa-layer-group me-2"></i>

                            All Types

                        </a>


                        {{-- FREE --}}
                        <a
                            href="{{ route('courses', [
                                'category_id' => request('category_id'),
                                'search' => request('search'),
                                'course_type' => 'free'
                            ]) }}"
                            class="d-flex align-items-center text-decoration-none
                            px-3 py-2 rounded-3 mb-2
                            {{ request('course_type') === 'free'
                                ? 'bg-success text-white'
                                : 'text-dark bg-light' }}">

                            <i class="fa-solid fa-gift me-2"></i>

                            Free Courses

                        </a>


                        {{-- PAID --}}
                        <a
                            href="{{ route('courses', [
                                'category_id' => request('category_id'),
                                'search' => request('search'),
                                'course_type' => 'paid'
                            ]) }}"
                            class="d-flex align-items-center text-decoration-none
                            px-3 py-2 rounded-3
                            {{ request('course_type') === 'paid'
                                ? 'bg-warning text-dark'
                                : 'text-dark bg-light' }}">

                            <i class="fa-solid fa-indian-rupee-sign me-2"></i>

                            Paid Courses

                        </a>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 RIGHT COURSE CONTENT
            ================================================= --}}
            <div class="col-lg-9">


                {{-- =================================================
                     SEARCH BOX
                ================================================= --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">

                        <form
                            action="{{ route('courses') }}"
                            method="GET">

                            <div class="row g-2">


                                {{-- SEARCH INPUT --}}
                                <div class="col-md-8">

                                    <div class="input-group">

                                        <span class="input-group-text bg-white">

                                            <i class="fa-solid fa-magnifying-glass"></i>

                                        </span>

                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control"
                                            placeholder="Search courses..."
                                            value="{{ request('search') }}">

                                    </div>

                                </div>


                                {{-- KEEP CATEGORY --}}
                                @if(request('category_id'))

                                <input
                                    type="hidden"
                                    name="category_id"
                                    value="{{ request('category_id') }}">

                                @endif


                                {{-- KEEP COURSE TYPE --}}
                                @if(request('course_type'))

                                <input
                                    type="hidden"
                                    name="course_type"
                                    value="{{ request('course_type') }}">

                                @endif


                                {{-- SEARCH BUTTON --}}
                                <div class="col-md-2">

                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100">

                                        <i class="fa-solid fa-search me-1"></i>

                                        Search

                                    </button>

                                </div>


                                {{-- CLEAR BUTTON --}}
                                <div class="col-md-2">

                                    @if(
                                    request('search') ||
                                    request('category_id') ||
                                    request('course_type')
                                    )

                                    <a
                                        href="{{ route('courses') }}"
                                        class="btn btn-outline-secondary w-100">

                                        <i class="fa-solid fa-xmark me-1"></i>

                                        Clear

                                    </a>

                                    @else

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary w-100"
                                        disabled>

                                        Clear

                                    </button>

                                    @endif

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- =================================================
                     FILTER RESULT INFORMATION
                ================================================= --}}
                @if(
                request('search') ||
                request('category_id') ||
                request('course_type')
                )

                @php

                $selectedCategory = $categories->firstWhere(
                'id',
                request('category_id')
                );

                @endphp


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="fw-bold mb-1">

                            @if(request('search'))

                            Search Results

                            @elseif($selectedCategory)

                            {{ $selectedCategory->name }} Courses

                            @elseif(request('course_type') === 'free')

                            Free Courses

                            @elseif(request('course_type') === 'paid')

                            Paid Courses

                            @else

                            Filtered Courses

                            @endif

                        </h4>


                        <p class="text-muted mb-0">

                            @if(request('search'))

                            Showing results for
                            <strong>
                                "{{ request('search') }}"
                            </strong>

                            @else

                            Showing courses matching your filters.

                            @endif


                            @if($selectedCategory)

                            <span class="ms-1">
                                in
                                <strong>
                                    {{ $selectedCategory->name }}
                                </strong>
                            </span>

                            @endif


                            @if(request('course_type') === 'free')

                            <span class="ms-1">
                                · Free courses
                            </span>

                            @elseif(request('course_type') === 'paid')

                            <span class="ms-1">
                                · Paid courses
                            </span>

                            @endif

                        </p>

                    </div>


                    {{-- RESULT COUNT --}}
                    <span class="badge bg-primary-subtle text-primary px-3 py-2">

                        {{ $courses->count() }}

                        {{ $courses->count() == 1
                                ? 'Course'
                                : 'Courses'
                            }}

                    </span>

                </div>

                @else

                <div class="mb-4">

                    <h4 class="fw-bold mb-1">
                        All Courses
                    </h4>

                    <p class="text-muted mb-0">
                        Explore all available courses.
                    </p>

                </div>

                @endif


                {{-- =================================================
                     COURSE GRID
                ================================================= --}}
                <div class="row g-4">

                    @forelse($courses as $course)

                    <div class="col-md-6 col-xl-4">

                        <div class="course-card shadow-sm h-100">


                            {{-- =================================
                                     COURSE IMAGE
                                ================================== --}}
                            @if($course->image)

                            <img
                                src="{{ asset('uploads/courses/' . $course->image) }}"
                                class="course-image"
                                alt="{{ $course->title }}">

                            @endif


                            {{-- =================================
                                     COURSE CONTENT
                                ================================== --}}
                            <div class="card-body d-flex flex-column">


                                {{-- CATEGORY --}}
                                <small class="text-muted mb-2">

                                    <i class="fa-solid fa-layer-group me-1"></i>

                                    {{ $course->category->name }}

                                </small>


                                {{-- COURSE TITLE --}}
                                <h5 class="fw-bold mt-1">

                                    {{ $course->title }}

                                </h5>


                                {{-- DESCRIPTION --}}
                                <p class="text-muted small mb-3">

                                    {{ Str::limit($course->description, 90) }}

                                </p>


                                <div class="mt-auto">


                                    {{-- =================================
                                             PRICE / COURSE TYPE
                                        ================================== --}}
                                    <div class="mb-3">

                                        @if($course->course_type === 'free')

                                        <span class="text-success fw-bold">

                                            <i class="fa-solid fa-gift me-1"></i>

                                            Free Course

                                        </span>

                                        @else

                                        <span class="fw-bold">

                                            <i class="fa-solid fa-indian-rupee-sign me-1"></i>

                                            ₹{{ number_format($course->price, 2) }}

                                        </span>

                                        @endif

                                    </div>


                                    {{-- VIEW DETAILS --}}
                                    <a
                                        href="{{ route('course.details', $course->id) }}"
                                        class="btn btn-primary w-100">

                                        <i class="fa-solid fa-eye me-1"></i>

                                        View Details

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>


                    @empty


                    {{-- =========================================
                             NO COURSES FOUND
                        ========================================== --}}
                    <div class="col-12">

                        <div class="text-center py-5">

                            <div
                                class="mb-3 text-muted"
                                style="font-size: 45px;">

                                <i class="fa-solid fa-book-open"></i>

                            </div>


                            <h5 class="fw-bold">
                                No courses found
                            </h5>


                            @if(
                            request('search') ||
                            request('category_id') ||
                            request('course_type')
                            )

                            <p class="text-muted mb-3">

                                No courses match your current
                                search or filter selection.

                            </p>


                            <a
                                href="{{ route('courses') }}"
                                class="btn btn-primary">

                                <i class="fa-solid fa-arrow-left me-1"></i>

                                View All Courses

                            </a>

                            @else

                            <p class="text-muted mb-0">

                                No active courses are currently available.

                            </p>

                            @endif

                        </div>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     LEARNING PATH SECTION
========================================================= --}}
<section class="py-5 bg-light">

    <div class="container">


        {{-- SECTION HEADER --}}
        <div class="text-center mb-5">

            <p class="text-uppercase text-primary fw-semibold small mb-2">

                Your learning path

            </p>

            <h2 class="fw-bold mb-2">

                Build momentum with every lesson

            </h2>

        </div>


        <div class="row g-4">


            {{-- ================================================
                 EXPERT GUIDANCE
            ================================================= --}}
            <div class="col-md-4">

                <div class="card border-0 h-100 p-4 shadow-sm">

                    <div
                        class="rounded-circle bg-primary-subtle text-primary
                        d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 52px; height: 52px;">

                        <i class="fa-solid fa-graduation-cap"></i>

                    </div>


                    <h5 class="fw-bold">
                        Expert guidance
                    </h5>


                    <p class="text-muted mb-0">

                        Access structured learning designed to help
                        you move from beginner to confident practitioner.

                    </p>

                </div>

            </div>


            {{-- ================================================
                 REAL OUTCOMES
            ================================================= --}}
            <div class="col-md-4">

                <div class="card border-0 h-100 p-4 shadow-sm">

                    <div
                        class="rounded-circle bg-success-subtle text-success
                        d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 52px; height: 52px;">

                        <i class="fa-solid fa-award"></i>

                    </div>


                    <h5 class="fw-bold">
                        Real outcomes
                    </h5>


                    <p class="text-muted mb-0">

                        Gain practical knowledge and skills that support
                        your long-term growth and career direction.

                    </p>

                </div>

            </div>


            {{-- ================================================
                 FLEXIBLE PACE
            ================================================= --}}
            <div class="col-md-4">

                <div class="card border-0 h-100 p-4 shadow-sm">

                    <div
                        class="rounded-circle bg-warning-subtle text-warning
                        d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 52px; height: 52px;">

                        <i class="fa-solid fa-clock"></i>

                    </div>


                    <h5 class="fw-bold">
                        Flexible pace
                    </h5>


                    <p class="text-muted mb-0">

                        Learn on your schedule with self-paced lessons
                        built around your time and goals.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection