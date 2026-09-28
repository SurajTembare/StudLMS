@extends('frontend.master')

@section('title', $course->title . ' | Student LMS')

@section('content')


{{-- =========================================================
     COURSE HERO SECTION
========================================================= --}}

<section class="page-hero text-white py-5">

    <div class="container py-5 hero-content">

        <div class="row align-items-center g-5">


            {{-- =================================================
                 COURSE INFORMATION
            ================================================= --}}

            <div class="col-lg-7">

                {{-- CATEGORY --}}
                <span class="course-badge bg-white text-primary mb-3">

                    <i class="fa-solid fa-layer-group me-1"></i>

                    {{ $course->category->name }}

                </span>


                {{-- COURSE TITLE --}}
                <h1 class="display-5 fw-black mb-3">

                    {{ $course->title }}

                </h1>


                {{-- COURSE DESCRIPTION --}}
                <p class="lead text-white-50 mb-4">

                    {{ $course->description }}

                </p>


                {{-- COURSE QUICK INFORMATION --}}
                <div class="d-flex flex-wrap gap-3">


                    {{-- SELF PACED --}}
                    <div class="stat-pill">

                        <i class="fa-solid fa-clock"></i>

                        Self-paced learning

                    </div>


                    {{-- LECTURE COUNT --}}
                    <div class="stat-pill">

                        <i class="fa-solid fa-video"></i>

                        {{ $totalLectures }}

                        {{ $totalLectures == 1 ? 'Lecture' : 'Lectures' }}

                    </div>


                    {{-- CERTIFICATE --}}
                    <div class="stat-pill">

                        <i class="fa-solid fa-certificate"></i>

                        Certificate

                    </div>


                </div>

            </div>



            {{-- =================================================
                 COURSE IMAGE
            ================================================= --}}

            <div class="col-lg-5">

                <div class="card border-0 overflow-hidden shadow-lg">


                    @if($course->image)

                    <img
                        src="{{ asset('uploads/courses/' . $course->image) }}"
                        class="img-fluid w-100"
                        style="height: 360px; object-fit: cover;"
                        alt="{{ $course->title }}">

                    @else

                    <div
                        class="d-flex align-items-center justify-content-center bg-light"
                        style="height: 360px;">

                        <i class="fa-solid fa-book fa-4x text-muted"></i>

                    </div>

                    @endif


                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     COURSE DETAILS SECTION
========================================================= --}}

<section class="py-5">

    <div class="container">

        <div class="row g-4">


            {{-- =================================================
                 LEFT CONTENT
            ================================================= --}}

            <div class="col-lg-8">


                {{-- =================================================
                     COURSE OVERVIEW
                ================================================= --}}

                <div class="card border-0 shadow-sm p-4 p-md-5 mb-4">

                    <h3 class="fw-bold mb-4">

                        <i class="fa-solid fa-circle-info text-primary me-2"></i>

                        Course Overview

                    </h3>


                    <div class="row g-4">


                        {{-- TOTAL LECTURES --}}
                        <div class="col-md-4">

                            <div class="d-flex align-items-center">

                                <div
                                    class="rounded-circle bg-primary-subtle text-primary
                                    d-flex align-items-center justify-content-center
                                    me-3"
                                    style="width: 50px; height: 50px;">

                                    <i class="fa-solid fa-video"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Course Content
                                    </small>

                                    <strong>

                                        {{ $totalLectures }}

                                        {{ $totalLectures == 1
                                            ? 'Lecture'
                                            : 'Lectures' }}

                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- LEARNING TYPE --}}
                        <div class="col-md-4">

                            <div class="d-flex align-items-center">

                                <div
                                    class="rounded-circle bg-success-subtle text-success
                                    d-flex align-items-center justify-content-center
                                    me-3"
                                    style="width: 50px; height: 50px;">

                                    <i class="fa-solid fa-clock"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Learning Type
                                    </small>

                                    <strong>
                                        Self-paced
                                    </strong>

                                </div>

                            </div>

                        </div>


                        {{-- CERTIFICATE --}}
                        <div class="col-md-4">

                            <div class="d-flex align-items-center">

                                <div
                                    class="rounded-circle bg-warning-subtle text-warning
                                    d-flex align-items-center justify-content-center
                                    me-3"
                                    style="width: 50px; height: 50px;">

                                    <i class="fa-solid fa-certificate"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Completion
                                    </small>

                                    <strong>
                                        Certificate
                                    </strong>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>



                {{-- =================================================
                     COURSE CONTENT
                ================================================= --}}

                <div class="card border-0 p-4 p-md-5 shadow-sm">

                    {{-- CONTENT HEADER --}}
                    <div class="d-flex justify-content-between
                                align-items-center mb-4">

                        <div>

                            <h3 class="fw-bold mb-1">

                                <i class="fa-solid fa-book-open text-primary me-2"></i>

                                Course Content

                            </h3>

                            <p class="text-muted mb-0">

                                {{ $totalLectures }}

                                {{ $totalLectures == 1
                                    ? 'lecture'
                                    : 'lectures' }}

                                available in this course.

                            </p>

                        </div>

                    </div>


                    {{-- LECTURE LIST --}}
                    <div class="d-grid gap-3">


                        @forelse($course->lectures as $lecture)


                        <div
                            class="lecture-item d-flex align-items-start
                                p-3 rounded-3 border">


                            {{-- LECTURE ICON --}}
                            <div
                                class="me-3 mt-1 d-flex align-items-center
                                    justify-content-center rounded-circle
                                    bg-primary-subtle text-primary
                                    flex-shrink-0"
                                style="width: 42px; height: 42px;">

                                <i class="fa-solid fa-play"></i>

                            </div>


                            {{-- LECTURE INFORMATION --}}
                            <div class="flex-grow-1">


                                <div class="fw-bold mb-1">

                                    {{ $lecture->lecture_order }}.

                                    {{ $lecture->title }}

                                </div>


                                @if($lecture->description)

                                <div class="small text-muted">

                                    {{ Str::limit(
                                                $lecture->description,
                                                120
                                            ) }}

                                </div>

                                @endif


                            </div>


                            {{-- LOCK ICON --}}
                            <div class="text-muted ms-2">

                                <i class="fa-solid fa-lock"></i>

                            </div>


                        </div>


                        @empty


                        <div class="text-center py-4">

                            <i
                                class="fa-solid fa-book-open fa-2x
                                    text-muted mb-3"></i>

                            <p class="text-muted mb-0">

                                No lectures have been added yet.

                            </p>

                        </div>


                        @endforelse


                    </div>

                </div>

            </div>



            {{-- =================================================
                 RIGHT SIDEBAR
            ================================================= --}}

            <div class="col-lg-4">

                <div
                    class="card border-0 shadow-sm p-4"
                    style="position: sticky; top: 20px;">


                    {{-- =================================================
                         COURSE PRICE
                    ================================================= --}}

                    <div class="mb-4">

                        <p class="text-muted mb-1">

                            Course Price

                        </p>


                        @if($course->course_type === 'free')


                        <div class="d-flex align-items-center gap-2">

                            <h3 class="text-success fw-bold mb-0">

                                Free

                            </h3>

                            <span
                                class="badge bg-success-subtle text-success">

                                Free Course

                            </span>

                        </div>


                        @else


                        <h3 class="fw-bold mb-0">

                            ₹{{ number_format($course->price, 2) }}

                        </h3>


                        @endif

                    </div>



                    {{-- =================================================
                         COURSE INFORMATION
                    ================================================= --}}

                    <div class="border-top border-bottom py-3 mb-4">


                        {{-- LECTURES --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                <i class="fa-solid fa-video me-2"></i>

                                Lectures

                            </span>

                            <strong>

                                {{ $totalLectures }}

                            </strong>

                        </div>


                        {{-- LEARNING TYPE --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                <i class="fa-solid fa-clock me-2"></i>

                                Learning

                            </span>

                            <strong>

                                Self-paced

                            </strong>

                        </div>


                        {{-- CERTIFICATE --}}
                        <div class="d-flex justify-content-between">

                            <span class="text-muted">

                                <i class="fa-solid fa-certificate me-2"></i>

                                Certificate

                            </span>

                            <strong class="text-success">

                                Included

                            </strong>

                        </div>


                    </div>



                    {{-- =================================================
                         GUEST USER
                    ================================================= --}}

                    @guest


                    <a
                        href="{{ route('login') }}"
                        class="btn btn-primary w-100">

                        <i class="fa-solid fa-right-to-bracket me-2"></i>

                        Login to Enroll

                    </a>


                    <p class="text-muted text-center small mt-3 mb-0">

                        Login or create an account to start learning.

                    </p>


                    @endguest



                    {{-- =================================================
                         AUTHENTICATED USER
                    ================================================= --}}

                    @auth


                    {{-- =================================================
                             COMPLETED COURSE
                        ================================================= --}}

                    @if($enrollmentStatus === 'completed')


                    <div
                        class="alert alert-success text-center mb-3">

                        <i
                            class="fa-solid fa-circle-check fa-2x mb-2"></i>

                        <div class="fw-bold">

                            Course Completed 🎓

                        </div>

                        <small>

                            You have successfully completed
                            this course.

                        </small>

                    </div>


                    <a
                        href="{{ route(
                                    'course.learn',
                                    $course->id
                                ) }}"
                        class="btn btn-success w-100">

                        <i class="fa-solid fa-eye me-2"></i>

                        Review Course

                    </a>


                    {{-- =================================================
                             ACTIVE ENROLLMENT
                        ================================================= --}}

                    @elseif($enrollmentStatus === 'active')


                    <a
                        href="{{ route(
                                    'course.learn',
                                    $course->id
                                ) }}"
                        class="btn btn-success w-100">

                        <i class="fa-solid fa-play me-2"></i>

                        Continue Learning

                    </a>


                    <p
                        class="text-success text-center
                                small mt-3 mb-0">

                        <i
                            class="fa-solid fa-circle-check me-1"></i>

                        You are already enrolled!

                    </p>


                    {{-- =================================================
                             NOT ENROLLED
                        ================================================= --}}

                    @else


                    <form
                        action="{{ route(
                                    'course.enroll',
                                    $course->id
                                ) }}"
                        method="POST">

                        @csrf


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i
                                class="fa-solid fa-graduation-cap
                                        me-2"></i>

                            Enroll Now

                        </button>


                    </form>


                    <p
                        class="text-muted text-center
                                small mt-3 mb-0">

                        Start learning at your own pace.

                    </p>


                    @endif


                    @endauth


                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
     BACK TO COURSES
========================================================= --}}

<section class="pb-5">

    <div class="container">

        <a
            href="{{ route('courses') }}"
            class="btn btn-outline-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>

            Back to Courses

        </a>

    </div>

</section>


@endsection