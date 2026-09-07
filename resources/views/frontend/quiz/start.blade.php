@extends('frontend.master')

@section('title', $quiz->title . ' | Quiz')

@section('content')

<div class="container py-5">

    {{-- Quiz Header --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start">

                <div>
                    <p class="text-muted mb-1">
                        {{ $course->title }}
                    </p>

                    <h2 class="fw-bold mb-2">
                        {{ $quiz->title }}
                    </h2>

                    @if($quiz->description)
                    <p class="text-muted mb-0">
                        {{ $quiz->description }}
                    </p>
                    @endif
                </div>

                <span class="badge bg-primary fs-6">
                    Pass: {{ $quiz->pass_percentage }}%
                </span>

            </div>

        </div>

    </div>


    {{-- Quiz Instructions --}}
    <div class="alert alert-info border-0 shadow-sm">

        <div class="d-flex">

            <i class="fa-solid fa-circle-info fa-lg me-3 mt-1"></i>

            <div>

                <strong>Quiz Instructions</strong>

                <ul class="mb-0 mt-2">
                    <li>Select one answer for each question.</li>
                    <li>All questions are required.</li>
                    <li>Review your answers before submitting.</li>
                    <li>Your result will be calculated automatically.</li>
                </ul>

            </div>

        </div>

    </div>


    {{-- Quiz Form --}}
    <form action="{{ route('student.quiz.submit', [
        'courseId' => $course->id,
        'quizId' => $quiz->id
    ]) }}"
        method="POST"
        id="quizForm">

        @csrf


        @foreach($quiz->questions as $index => $question)

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body p-4">

                {{-- Question --}}
                <div class="mb-3">

                    <span class="badge bg-secondary mb-2">
                        Question {{ $index + 1 }}
                    </span>

                    <h5 class="fw-bold mb-0">
                        {{ $question->question }}
                    </h5>

                </div>


                {{-- Option A --}}
                <div class="form-check border rounded p-3 mb-2">

                    <input class="form-check-input ms-0 me-2"
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        value="a"
                        id="question{{ $question->id }}a"
                        required>

                    <label class="form-check-label"
                        for="question{{ $question->id }}a">

                        <strong>A.</strong>
                        {{ $question->option_a }}

                    </label>

                </div>


                {{-- Option B --}}
                <div class="form-check border rounded p-3 mb-2">

                    <input class="form-check-input ms-0 me-2"
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        value="b"
                        id="question{{ $question->id }}b"
                        required>

                    <label class="form-check-label"
                        for="question{{ $question->id }}b">

                        <strong>B.</strong>
                        {{ $question->option_b }}

                    </label>

                </div>


                {{-- Option C --}}
                <div class="form-check border rounded p-3 mb-2">

                    <input class="form-check-input ms-0 me-2"
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        value="c"
                        id="question{{ $question->id }}c"
                        required>

                    <label class="form-check-label"
                        for="question{{ $question->id }}c">

                        <strong>C.</strong>
                        {{ $question->option_c }}

                    </label>

                </div>


                {{-- Option D --}}
                <div class="form-check border rounded p-3">

                    <input class="form-check-input ms-0 me-2"
                        type="radio"
                        name="answers[{{ $question->id }}]"
                        value="d"
                        id="question{{ $question->id }}d"
                        required>

                    <label class="form-check-label"
                        for="question{{ $question->id }}d">

                        <strong>D.</strong>
                        {{ $question->option_d }}

                    </label>

                </div>

            </div>

        </div>

        @endforeach


        {{-- Submit Section --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <a href="{{ route('course.learn', $course->id) }}"
                        class="btn btn-outline-secondary">

                        <i class="fa-solid fa-arrow-left me-2"></i>
                        Back to Course

                    </a>


                    <button type="submit"
                        class="btn btn-primary px-4">

                        <i class="fa-solid fa-paper-plane me-2"></i>
                        Submit Quiz

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- Confirmation before submitting --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const quizForm = document.getElementById('quizForm');

        if (!quizForm) {
            return;
        }

        quizForm.addEventListener('submit', function(event) {

            const confirmed = confirm(
                'Are you sure you want to submit the quiz?'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });
</script>

@endsection