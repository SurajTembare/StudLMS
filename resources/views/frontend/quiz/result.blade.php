@extends('frontend.master')

@section('title', 'Quiz Result | ' . $quiz->title)

@section('content')

<div class="container py-5">

    ```
    {{-- ================= RESULT HEADER ================= --}}
    <div class="text-center mb-4">

        @if($attempt->result === 'pass')

        <div class="mb-3">
            <i class="fa-solid fa-circle-check text-success fa-4x"></i>
        </div>

        <h2 class="fw-bold text-success">
            Congratulations! 🎉
        </h2>

        <p class="text-muted">
            You have successfully passed this quiz.
        </p>

        @else

        <div class="mb-3">
            <i class="fa-solid fa-circle-xmark text-danger fa-4x"></i>
        </div>

        <h2 class="fw-bold text-danger">
            Quiz Not Passed
        </h2>

        <p class="text-muted">
            Review the course material and try the quiz again.
        </p>

        @endif

    </div>


    {{-- ================= QUIZ INFORMATION ================= --}}
    <div class="text-center mb-4">

        <h4 class="fw-bold mb-1">
            {{ $quiz->title }}
        </h4>

        <p class="text-muted mb-0">
            {{ $course->title }}
        </p>

    </div>


    {{-- ================= RESULT CARD ================= --}}
    <div class="row justify-content-center">

        <div class="col-md-8 col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">


                    {{-- ================= SCORE ================= --}}
                    <div class="text-center mb-4">

                        <div class="display-3 fw-bold
                        {{ $attempt->result === 'pass'
                            ? 'text-success'
                            : 'text-danger' }}">

                            {{ $attempt->percentage }}%

                        </div>

                        <div class="text-muted">
                            Your Score
                        </div>

                    </div>


                    {{-- ================= SCORE BAR ================= --}}
                    <div class="mb-4">

                        <div class="progress"
                            style="height: 10px;">

                            <div class="progress-bar
                            {{ $attempt->result === 'pass'
                                ? 'bg-success'
                                : 'bg-danger' }}"
                                role="progressbar"
                                data-score="{{ $attempt->percentage }}"
                                aria-valuenow="{{ $attempt->percentage }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>

                        </div>

                    </div>


                    <hr>


                    {{-- ================= SCORE DETAILS ================= --}}
                    <div class="row text-center g-3">

                        <div class="col-4">

                            <div class="fw-bold fs-4">
                                {{ $attempt->total_questions }}
                            </div>

                            <small class="text-muted">
                                Total Questions
                            </small>

                        </div>


                        <div class="col-4">

                            <div class="fw-bold fs-4 text-success">
                                {{ $attempt->correct_answers }}
                            </div>

                            <small class="text-muted">
                                Correct
                            </small>

                        </div>


                        <div class="col-4">

                            <div class="fw-bold fs-4 text-danger">
                                {{ $attempt->total_questions - $attempt->correct_answers }}
                            </div>

                            <small class="text-muted">
                                Incorrect
                            </small>

                        </div>

                    </div>


                    <hr>


                    {{-- ================= PASS REQUIREMENT ================= --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-muted">
                            Required to Pass
                        </span>

                        <strong>
                            {{ $quiz->pass_percentage }}%
                        </strong>

                    </div>


                    {{-- ================= RESULT STATUS ================= --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="text-muted">
                            Result
                        </span>

                        @if($attempt->result === 'pass')

                        <span class="badge bg-success fs-6 px-3 py-2">

                            <i class="fa-solid fa-check me-1"></i>
                            PASSED

                        </span>

                        @else

                        <span class="badge bg-danger fs-6 px-3 py-2">

                            <i class="fa-solid fa-xmark me-1"></i>
                            FAILED

                        </span>

                        @endif

                    </div>


                    {{-- ================= ATTEMPT DATE ================= --}}
                    @if($attempt->attempted_at)

                    <div class="text-center">

                        <small class="text-muted">

                            <i class="fa-regular fa-clock me-1"></i>

                            Attempted on
                            {{ $attempt->attempted_at->format('d M Y, h:i A') }}

                        </small>

                    </div>

                    @endif

                </div>

            </div>


            {{-- ================= ACTION BUTTONS ================= --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">


                {{-- Back to Course --}}
                <a href="{{ route('course.learn', $course->id) }}"
                    class="btn btn-outline-secondary">

                    <i class="fa-solid fa-book-open me-2"></i>
                    Back to Course

                </a>


                {{-- Attempt History --}}
                <a href="{{ route('student.quiz.history', [
                'courseId' => $course->id,
                'quizId' => $quiz->id
            ]) }}"
                    class="btn btn-outline-primary">

                    <i class="fa-solid fa-clock-rotate-left me-2"></i>
                    Attempt History

                </a>


                {{-- Retake / Continue --}}
                @if($attempt->result === 'fail')

                <a href="{{ route('student.quiz.start', [
                    'courseId' => $course->id,
                    'quizId' => $quiz->id
                ]) }}"
                    class="btn btn-primary">

                    <i class="fa-solid fa-rotate-right me-2"></i>
                    Retake Quiz

                </a>

                @else

                <a href="{{ route('course.learn', $course->id) }}"
                    class="btn btn-success">

                    <i class="fa-solid fa-arrow-right me-2"></i>
                    Continue Course

                </a>

                @endif

            </div>

        </div>

    </div>
    ```

</div>

{{-- ================= SCORE BAR JAVASCRIPT ================= --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const scoreBar = document.querySelector('[data-score]');

        if (!scoreBar) {
            return;
        }

        const score = Number(scoreBar.dataset.score);

        if (Number.isNaN(score)) {
            return;
        }

        scoreBar.style.width = Math.min(Math.max(score, 0), 100) + '%';

    });
</script>

@endsection