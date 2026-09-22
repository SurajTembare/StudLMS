
@extends('frontend.master')

@section('title', 'My Learning')

@section('content')

<div class="container py-5">

    {{-- ================= PAGE HEADING ================= --}}
    <div class="mb-5">

        <h2 class="fw-bold">My Learning</h2>

        <p class="text-muted mb-0">
            Continue learning and track your course progress.
        </p>

    </div>


    {{-- ================= SUCCESS MESSAGE ================= --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================= ERROR MESSAGE ================= --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="fa-solid fa-circle-exclamation me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================= ENROLLED COURSES ================= --}}
    @if($enrollments->count() > 0)

        <div class="row g-4">

            @foreach($enrollments as $enrollment)

                @if($enrollment->course)

                    @php

                        $course = $enrollment->course;

                        $progressPercentage =
                            $enrollment->progressPercentage ?? 0;

                        $completedCount =
                            $enrollment->completedCount ?? 0;

                        $totalLectures =
                            $enrollment->totalLectures ?? 0;

                        $contentFinalized =
                            (bool) ($course->content_finalized ?? false);

                    @endphp


                    <div class="col-md-6 col-lg-4">

                        <div class="card h-100 border-0 shadow-sm">


                            {{-- ================= COURSE IMAGE ================= --}}
                            @if($course->image)

                                <img
                                    src="{{ asset('uploads/courses/' . $course->image) }}"
                                    class="card-img-top"
                                    alt="{{ $course->title }}"
                                    style="height: 180px; object-fit: cover;">

                            @else

                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 180px;">

                                    <i class="fa-solid fa-book fa-3x text-muted"></i>

                                </div>

                            @endif


                            <div class="card-body d-flex flex-column">


                                {{-- ================= COURSE TITLE ================= --}}
                                <h5 class="fw-bold">

                                    {{ $course->title }}

                                </h5>


                                {{-- ================= COURSE STATUS ================= --}}
                                @if($enrollment->status === 'completed')

                                    <span
                                        class="badge bg-success mb-3 align-self-start">

                                        <i class="fa-solid fa-circle-check me-1"></i>

                                        Course Completed 🎓

                                    </span>
                                    


                                @elseif(!$contentFinalized)

                                    <span
                                        class="badge bg-warning text-dark mb-3 align-self-start">

                                        <i class="fa-solid fa-pen me-1"></i>

                                        Content In Progress

                                    </span>


                                @elseif(
                                    $totalLectures > 0
                                    &&
                                    $completedCount >= $totalLectures
                                )

                                    <span
                                        class="badge bg-warning text-dark mb-3 align-self-start">

                                        <i class="fa-solid fa-file-circle-question me-1"></i>

                                        Quiz Pending

                                    </span>


                                @else

                                    <span
                                        class="badge bg-primary mb-3 align-self-start">

                                        <i class="fa-solid fa-spinner me-1"></i>

                                        In Progress

                                    </span>

                                @endif


                                {{-- ================= COURSE PROGRESS ================= --}}
                                <div
                                    class="d-flex justify-content-between mb-2">

                                    <small class="text-muted">
                                        Course Progress
                                    </small>

                                    <small class="fw-bold text-primary">
                                        {{ $progressPercentage }}%
                                    </small>

                                </div>


                                {{-- ================= PROGRESS BAR ================= --}}
                                <div
                                    class="progress mb-2"
                                    style="height: 8px;">

                                    <div
                                        class="progress-bar course-progress-bar"
                                        role="progressbar"
                                        data-progress="{{ $progressPercentage }}"
                                        aria-valuenow="{{ $progressPercentage }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>

                                </div>


                                {{-- ================= LECTURE COUNT ================= --}}
                                <small class="text-muted mb-3">

                                    <i class="fa-solid fa-video me-1"></i>

                                    {{ $completedCount }}
                                    of
                                    {{ $totalLectures }}
                                    lectures completed

                                </small>


                                {{-- ================= COMPLETION DATE ================= --}}
                                @if(
                                    $enrollment->status === 'completed'
                                    &&
                                    $enrollment->completed_at
                                )

                                    <small class="text-success mb-3">

                                        <i class="fa-solid fa-calendar-check me-1"></i>

                                        Completed on

                                        {{ \Carbon\Carbon::parse(
                                            $enrollment->completed_at
                                        )->format('d M Y') }}

                                    </small>

                                @endif


                                {{-- ================= CONTENT IN PROGRESS MESSAGE ================= --}}
                                @if(
                                    $enrollment->status !== 'completed'
                                    &&
                                    !$contentFinalized
                                )

                                    <div
                                        class="alert alert-warning py-2 small mb-3">

                                        <i class="fa-solid fa-circle-info me-1"></i>

                                        @if(
                                            $totalLectures > 0
                                            &&
                                            $completedCount >= $totalLectures
                                        )

                                            You have completed all currently
                                            available lectures. Additional
                                            course content may be added by
                                            the instructor.

                                        @else

                                            Course content is currently being
                                            updated. You can continue learning
                                            the available lectures.

                                        @endif

                                    </div>

                                @endif


                                {{-- ================= QUIZ PENDING MESSAGE ================= --}}
                                @if(
                                    $enrollment->status !== 'completed'
                                    &&
                                    $contentFinalized
                                    &&
                                    $totalLectures > 0
                                    &&
                                    $completedCount >= $totalLectures
                                )

                                    <div
                                        class="alert alert-info py-2 small mb-3">

                                        <i class="fa-solid fa-circle-info me-1"></i>

                                        You have completed all lectures.
                                        Please pass all required quizzes
                                        to complete this course.

                                    </div>

                                @endif


                                {{-- ================= COURSE ACTION BUTTON ================= --}}
                                <div class="mt-auto">

                                    <a
                                        href="{{ route(
                                            'course.learn',
                                            $course->id
                                        ) }}"
                                        class="btn
                                        @if($enrollment->status === 'completed')
                                            btn-success
                                        @elseif(
                                            $contentFinalized
                                            &&
                                            $totalLectures > 0
                                            &&
                                            $completedCount >= $totalLectures
                                        )
                                            btn-warning
                                        @else
                                            btn-primary
                                        @endif
                                        w-100">


                                        {{-- COMPLETED --}}
                                        @if($enrollment->status === 'completed')

                                            <i class="fa-solid fa-eye me-2"></i>

                                            Review Course


                                        {{-- CONTENT NOT FINALIZED --}}
                                        @elseif(!$contentFinalized)

                                            <i class="fa-solid fa-book-open me-2"></i>

                                            @if($completedCount > 0)
                                                Continue Learning
                                            @else
                                                Start Learning
                                            @endif


                                        {{-- QUIZ PENDING --}}
                                        @elseif(
                                            $totalLectures > 0
                                            &&
                                            $completedCount >= $totalLectures
                                        )

                                            <i class="fa-solid fa-file-circle-question me-2"></i>

                                            Take Quiz


                                        {{-- CONTINUE LEARNING --}}
                                        @elseif($completedCount > 0)

                                            <i class="fa-solid fa-play me-2"></i>

                                            Continue Learning


                                        {{-- START LEARNING --}}
                                        @else

                                            <i class="fa-solid fa-play me-2"></i>

                                            Start Learning

                                        @endif

                                    </a>

                                </div>


                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>


    @else

        {{-- ================= NO ENROLLED COURSES ================= --}}
        <div class="text-center py-5">

            <i
                class="fa-solid fa-graduation-cap fa-4x text-muted mb-3">
            </i>

            <h4>
                You haven't enrolled in any courses yet.
            </h4>

            <p class="text-muted">
                Explore our courses and start learning today!
            </p>


            <a
                href="{{ route('courses') }}"
                class="btn btn-primary">

                <i class="fa-solid fa-book-open me-2"></i>

                Browse Courses

            </a>

        </div>

    @endif


</div>


{{-- ================= PROGRESS BAR JAVASCRIPT ================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const progressBars =
        document.querySelectorAll('.course-progress-bar');


    progressBars.forEach(function (progressBar) {

        let progress =
            Number(progressBar.dataset.progress);


        if (Number.isNaN(progress)) {
            progress = 0;
        }


        const safeProgress =
            Math.min(
                Math.max(progress, 0),
                100
            );


        progressBar.style.width =
            safeProgress + '%';

    });

});

</script>

@endsection

