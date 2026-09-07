
@extends('frontend.master')

@section('title', $course->title . ' | Learning')

@section('content')

@php

    $lectures = $course->lectures->values();

    $currentIndex = false;

    if ($currentLecture) {
        $currentIndex = $lectures->search(function ($lecture) use ($currentLecture) {
            return $lecture->id == $currentLecture->id;
        });
    }

    $previousLecture = null;
    $nextLecture = null;

    if ($currentIndex !== false && $currentIndex > 0) {
        $previousLecture = $lectures[$currentIndex - 1];
    }

    if (
        $currentIndex !== false &&
        $currentIndex < $lectures->count() - 1
    ) {
        $nextLecture = $lectures[$currentIndex + 1];
    }

    $isCurrentLectureCompleted = false;

    if ($currentLecture) {
        $isCurrentLectureCompleted = in_array(
            $currentLecture->id,
            $completedLectureIds
        );
    }

    $contentFinalized = (bool) ($course->content_finalized ?? false);

    $allLecturesCompleted =
        $totalLectures > 0 &&
        $completedCount >= $totalLectures;

    $courseCompleted =
        isset($enrollment) &&
        $enrollment->status === 'completed';

@endphp


<div class="container-fluid py-4">


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


    <div class="row g-4">


        {{-- =====================================================
             MAIN LEARNING AREA
        ====================================================== --}}
        <div class="col-lg-8">


            {{-- Back Button --}}
            <a
                href="{{ route('my.learning') }}"
                class="text-decoration-none text-muted small">

                <i class="fa-solid fa-arrow-left me-1"></i>

                Back to My Learning

            </a>


            {{-- ================= COURSE TITLE ================= --}}
            <div class="mt-2 mb-3">

                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                    <div>

                        <h3 class="fw-bold mb-1">

                            {{ $course->title }}

                        </h3>


                        @if($currentLecture)

                            <p class="text-muted mb-0">

                                <i class="fa-solid fa-circle-play me-1"></i>

                                Lecture {{ $currentLecture->lecture_order }}:

                                {{ $currentLecture->title }}

                            </p>

                        @endif

                    </div>


                    {{-- Course Status Badge --}}
                    <div>

                        @if($courseCompleted)

                            <span class="badge bg-success">

                                <i class="fa-solid fa-circle-check me-1"></i>

                                Course Completed

                            </span>

                        @elseif(!$contentFinalized)

                            <span class="badge bg-warning text-dark">

                                <i class="fa-solid fa-pen me-1"></i>

                                Content In Progress

                            </span>

                        @elseif($allLecturesCompleted)

                            <span class="badge bg-info">

                                <i class="fa-solid fa-file-circle-question me-1"></i>

                                Quiz Pending

                            </span>

                        @else

                            <span class="badge bg-primary">

                                <i class="fa-solid fa-spinner me-1"></i>

                                In Progress

                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 COURSE PROGRESS
            ====================================================== --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <strong>

                            <i class="fa-solid fa-chart-line me-2 text-primary"></i>

                            Course Progress

                        </strong>


                        <span class="fw-bold text-primary">

                            {{ $progressPercentage }}%

                        </span>

                    </div>


                    <div
                        class="progress"
                        style="height: 10px;">

                        <div
                            id="courseProgressBar"
                            class="progress-bar"
                            role="progressbar"
                            data-progress="{{ $progressPercentage }}"
                            aria-valuenow="{{ $progressPercentage }}"
                            aria-valuemin="0"
                            aria-valuemax="100">

                        </div>

                    </div>


                    <small class="text-muted d-block mt-2">

                        {{ $completedCount }}

                        of

                        {{ $totalLectures }}

                        lectures completed

                    </small>


                    {{-- Content Still Being Added --}}
                    @if(
                        !$courseCompleted &&
                        !$contentFinalized
                    )

                        <div class="alert alert-warning mt-3 mb-0 py-2">

                            <i class="fa-solid fa-circle-info me-2"></i>

                            @if($allLecturesCompleted)

                                You have completed all currently available
                                lectures. The instructor may add more content
                                before finalizing this course.

                            @else

                                Course content is currently being updated.
                                You can continue learning the available
                                lectures.

                            @endif

                        </div>

                    @endif


                    {{-- Quiz Required --}}
                    @if(
                        !$courseCompleted &&
                        $contentFinalized &&
                        $allLecturesCompleted
                    )

                        <div class="alert alert-info mt-3 mb-0 py-2">

                            <i class="fa-solid fa-circle-info me-2"></i>

                            You have completed all lectures. Complete and
                            pass the required quiz to finish this course.

                        </div>

                    @endif


                    {{-- Course Completed --}}
                    @if($courseCompleted)

                        <div class="alert alert-success mt-3 mb-0 py-2">

                            <i class="fa-solid fa-graduation-cap me-2"></i>

                            Congratulations! You have successfully completed
                            this course.

                        </div>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                 CURRENT LECTURE
            ====================================================== --}}
            @if($currentLecture)


                {{-- ================= UPLOADED VIDEO ================= --}}
                @if($currentLecture->video)

                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">

                        <div class="card-body p-0 bg-dark">

                            <video
                                id="lectureVideo"
                                class="w-100 d-block"
                                controls
                                controlsList="nodownload"
                                preload="metadata"
                                data-complete-url="{{ route(
                                    'lecture.complete',
                                    [$course->id, $currentLecture->id]
                                ) }}"
                                data-csrf="{{ csrf_token() }}">

                                <source
                                    src="{{ asset(
                                        'uploads/lectures/videos/' .
                                        $currentLecture->video
                                    ) }}"
                                    type="video/mp4">

                                Your browser does not support video playback.

                            </video>

                        </div>

                    </div>


                {{-- ================= EXTERNAL VIDEO ================= --}}
                @elseif($currentLecture->video_url)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body text-center py-5">

                            <i class="fa-solid fa-circle-play fa-4x text-primary mb-3"></i>

                            <h5>
                                Video Lecture
                            </h5>

                            <p class="text-muted">
                                Click the button below to watch this lecture.
                            </p>


                            <a
                                href="{{ $currentLecture->video_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-primary">

                                <i class="fa-solid fa-play me-2"></i>

                                Watch Video

                            </a>

                        </div>

                    </div>


                {{-- ================= NO VIDEO ================= --}}
                @else

                    <div class="alert alert-info">

                        <i class="fa-solid fa-circle-info me-2"></i>

                        No video has been added for this lecture yet.

                    </div>

                @endif


                {{-- =====================================================
                     LECTURE DESCRIPTION
                ====================================================== --}}
                @if($currentLecture->description)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <h5 class="fw-bold">

                                <i class="fa-solid fa-book-open me-2 text-primary"></i>

                                About this Lecture

                            </h5>


                            <p class="mb-0 text-muted">

                                {{ $currentLecture->description }}

                            </p>

                        </div>

                    </div>

                @endif


                {{-- =====================================================
                     LECTURE NOTES
                ====================================================== --}}
                @if($currentLecture->document)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <h5 class="fw-bold">

                                <i class="fa-solid fa-file-pdf text-danger me-2"></i>

                                Lecture Notes

                            </h5>


                            <p class="text-muted small">

                                View the notes for this lecture.

                            </p>


                            <a
                                href="{{ asset(
                                    'uploads/lectures/documents/' .
                                    $currentLecture->document
                                ) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-outline-primary">

                                <i class="fa-solid fa-eye me-2"></i>

                                View Notes

                            </a>

                        </div>

                    </div>

                @endif


                {{-- =====================================================
                     LECTURE COMPLETION
                ====================================================== --}}
                <div class="mb-4">


                    @if($isCurrentLectureCompleted)

                        <button
                            type="button"
                            class="btn btn-success"
                            disabled>

                            <i class="fa-solid fa-circle-check me-2"></i>

                            Completed

                        </button>


                    @else

                        <form
                            action="{{ route(
                                'lecture.complete',
                                [
                                    $course->id,
                                    $currentLecture->id
                                ]
                            ) }}"
                            method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success">

                                <i class="fa-solid fa-check me-2"></i>

                                Mark as Complete

                            </button>

                        </form>

                    @endif

                </div>


                {{-- =====================================================
                     PREVIOUS / NEXT NAVIGATION
                ====================================================== --}}
                <div class="d-flex justify-content-between align-items-center mt-4 mb-4">


                    {{-- Previous Lecture --}}
                    <div>

                        @if($previousLecture)

                            <a
                                href="{{ route(
                                    'course.learn.lecture',
                                    [
                                        'courseId' => $course->id,
                                        'lectureId' => $previousLecture->id
                                    ]
                                ) }}"
                                class="btn btn-outline-secondary">

                                <i class="fa-solid fa-arrow-left me-2"></i>

                                Previous

                            </a>

                        @endif

                    </div>


                    {{-- Next Lecture --}}
                    <div>

                        @if($nextLecture)

                            <a
                                href="{{ route(
                                    'course.learn.lecture',
                                    [
                                        'courseId' => $course->id,
                                        'lectureId' => $nextLecture->id
                                    ]
                                ) }}"
                                class="btn btn-primary">

                                Next

                                <i class="fa-solid fa-arrow-right ms-2"></i>

                            </a>

                        @else

                            <span class="badge bg-success p-2">

                                <i class="fa-solid fa-check me-1"></i>

                                Last Lecture

                            </span>

                        @endif

                    </div>

                </div>


            @else


                {{-- ================= NO LECTURES ================= --}}
                <div class="alert alert-warning">

                    <i class="fa-solid fa-triangle-exclamation me-2"></i>

                    No lectures are available in this course yet.

                </div>

            @endif



            {{-- =====================================================
                 COURSE QUIZZES
            ====================================================== --}}
            @if($course->quizzes->where('status', 'active')->count() > 0)

                <div class="card border-0 shadow-sm mt-4 mb-4">

                    <div class="card-header bg-white py-3">

                        <h5 class="fw-bold mb-0">

                            <i class="fa-solid fa-file-circle-question text-primary me-2"></i>

                            Course Quiz

                        </h5>

                    </div>


                    <div class="card-body">


                        @foreach(
                            $course->quizzes->where('status', 'active')
                            as $quiz
                        )

                            <div class="border rounded p-3 mb-3">

                                <div class="row align-items-center">


                                    {{-- Quiz Information --}}
                                    <div class="col-md-8">

                                        <h5 class="fw-bold mb-1">

                                            {{ $quiz->title }}

                                        </h5>


                                        @if($quiz->description)

                                            <p class="text-muted mb-2">

                                                {{ $quiz->description }}

                                            </p>

                                        @endif


                                        <small class="text-muted">

                                            <i class="fa-solid fa-circle-question me-1"></i>

                                            {{ $quiz->questions->count() }}

                                            Questions

                                            <span class="mx-2">|</span>

                                            Pass:

                                            {{ $quiz->pass_percentage }}%

                                        </small>

                                    </div>


                                    {{-- Quiz Action --}}
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">


                                        {{-- Quiz is available only when:
                                             1. Course content is finalized
                                             2. All lectures are completed
                                        --}}
                                        @if(
                                            $contentFinalized &&
                                            $allLecturesCompleted
                                        )

                                            <a
                                                href="{{ route(
                                                    'student.quiz.start',
                                                    [
                                                        'courseId' => $course->id,
                                                        'quizId' => $quiz->id
                                                    ]
                                                ) }}"
                                                class="btn btn-primary">

                                                <i class="fa-solid fa-play me-2"></i>

                                                Start Quiz

                                            </a>


                                            <a
                                                href="{{ route(
                                                    'student.quiz.history',
                                                    [
                                                        'courseId' => $course->id,
                                                        'quizId' => $quiz->id
                                                    ]
                                                ) }}"
                                                class="btn btn-outline-primary mt-2">

                                                <i class="fa-solid fa-clock-rotate-left me-1"></i>

                                                History

                                            </a>


                                        @else

                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                disabled>

                                                <i class="fa-solid fa-lock me-2"></i>

                                                Locked

                                            </button>

                                        @endif

                                    </div>

                                </div>


                                {{-- Quiz Locked Message --}}
                                @if(!$contentFinalized)

                                    <div class="alert alert-warning mt-3 mb-0">

                                        <i class="fa-solid fa-lock me-2"></i>

                                        The quiz will be available after the
                                        instructor finalizes the course content.

                                    </div>


                                @elseif(!$allLecturesCompleted)

                                    <div class="alert alert-warning mt-3 mb-0">

                                        <i class="fa-solid fa-lock me-2"></i>

                                        Complete all lectures to unlock this quiz.

                                    </div>

                                @endif

                            </div>

                        @endforeach


                    </div>

                </div>

            @endif


        </div>



        {{-- =====================================================
             LECTURE SIDEBAR
        ====================================================== --}}
        <div class="col-lg-4">


            {{-- Course Content --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="fw-bold mb-0">

                            <i class="fa-solid fa-list me-2"></i>

                            Course Content

                        </h5>


                        <span class="badge bg-primary">

                            {{ $totalLectures }}

                        </span>

                    </div>

                </div>


                <div class="list-group list-group-flush">


                    @forelse($course->lectures as $lecture)

                        @php

                            $isCompleted = in_array(
                                $lecture->id,
                                $completedLectureIds
                            );

                        @endphp


                        <a
                            href="{{ route(
                                'course.learn.lecture',
                                [
                                    'courseId' => $course->id,
                                    'lectureId' => $lecture->id
                                ]
                            ) }}"
                            class="list-group-item list-group-item-action d-flex align-items-center
                            {{ $currentLecture && $currentLecture->id == $lecture->id ? 'active' : '' }}">


                            {{-- Completion Icon --}}
                            <div class="me-3">

                                @if($isCompleted)

                                    <i class="fa-solid fa-circle-check text-success"></i>

                                @else

                                    <i
                                        class="fa-solid fa-circle-play
                                        {{ $currentLecture && $currentLecture->id == $lecture->id ? '' : 'text-primary' }}">
                                    </i>

                                @endif

                            </div>


                            {{-- Lecture Information --}}
                            <div class="flex-grow-1">

                                <strong>

                                    {{ $lecture->lecture_order }}.

                                    {{ $lecture->title }}

                                </strong>


                                @if($lecture->description)

                                    <small
                                        class="d-block
                                        {{ $currentLecture && $currentLecture->id == $lecture->id ? '' : 'text-muted' }}">

                                        {{ Str::limit(
                                            $lecture->description,
                                            45
                                        ) }}

                                    </small>

                                @endif

                            </div>


                            {{-- Completed Badge --}}
                            @if($isCompleted)

                                <span class="badge bg-success ms-2">

                                    Done

                                </span>

                            @endif

                        </a>


                    @empty

                        <div class="p-4 text-center text-muted">

                            <i class="fa-solid fa-video-slash fa-2x mb-2"></i>

                            <p class="mb-0">

                                No lectures available.

                            </p>

                        </div>

                    @endforelse


                </div>

            </div>


            {{-- Sidebar Progress Summary --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body text-center">

                    <i class="fa-solid fa-graduation-cap fa-2x text-primary mb-2"></i>

                    <h6 class="fw-bold">

                        Your Progress

                    </h6>


                    <h3 class="fw-bold text-primary">

                        {{ $progressPercentage }}%

                    </h3>


                    <p class="text-muted small mb-0">

                        {{ $completedCount }}

                        of

                        {{ $totalLectures }}

                        lectures completed

                    </p>


                    @if($courseCompleted)

                        <span class="badge bg-success mt-2">

                            <i class="fa-solid fa-circle-check me-1"></i>

                            Completed

                        </span>

                    @elseif(!$contentFinalized)

                        <span class="badge bg-warning text-dark mt-2">

                            Content In Progress

                        </span>

                    @endif

                </div>

            </div>


        </div>

    </div>

</div>


{{-- =====================================================
     JAVASCRIPT
====================================================== --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
     * Course Progress Bar
     */
    const progressBar =
        document.getElementById('courseProgressBar');


    if (progressBar) {

        let progress =
            Number(progressBar.dataset.progress);


        if (Number.isNaN(progress)) {
            progress = 0;
        }


        progress = Math.min(
            Math.max(progress, 0),
            100
        );


        progressBar.style.width =
            progress + '%';

    }


    /*
     * Automatic Video Completion
     */
    const video =
        document.getElementById('lectureVideo');


    if (!video) {
        return;
    }


    const completeUrl =
        video.dataset.completeUrl;


    const csrfToken =
        video.dataset.csrf;


    if (!completeUrl || !csrfToken) {
        return;
    }


    let completionSent = false;


    video.addEventListener(
        'ended',
        function () {

            if (completionSent) {
                return;
            }


            completionSent = true;


            fetch(
                completeUrl,
                {
                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            )

            .then(function (response) {

                if (!response.ok) {

                    throw new Error(
                        'Failed to mark lecture as completed.'
                    );

                }


                return response.json();

            })

            .then(function (data) {

                if (data.success) {

                    window.location.reload();

                } else {

                    completionSent = false;

                    console.error(
                        'Lecture completion failed.'
                    );

                }

            })

            .catch(function (error) {

                completionSent = false;

                console.error(
                    'Completion error:',
                    error
                );

            });

        }
    );

});

</script>

@endsection

