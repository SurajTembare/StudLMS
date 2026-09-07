@extends('admin.master')

@section('title', 'Quiz Questions')

@section('content')

<div class="container-fluid">


<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">{{ $quiz->title }}</h3>
        <p class="text-muted mb-0">
            Manage questions for this quiz.
        </p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.quizzes.index') }}"
           class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Back to Quizzes
        </a>

        <a href="{{ route('admin.quiz.questions.create', $quiz->id) }}"
           class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i>
            Add Question
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif

<div class="card border-0 shadow-sm">

    <div class="card-body">

        @forelse($quiz->questions as $question)

            <div class="border rounded p-3 mb-3">

                <div class="d-flex justify-content-between">

                    <h6 class="fw-bold">
                        {{ $question->question_order }}.
                        {{ $question->question }}
                    </h6>

                    <div>
                        <a href="{{ route('admin.quiz.questions.edit', [
                            $quiz->id,
                            $question->id
                        ]) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form action="{{ route('admin.quiz.questions.destroy', [
                            $quiz->id,
                            $question->id
                        ]) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this question?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-6">
                        <p class="{{ $question->correct_answer === 'a' ? 'text-success fw-bold' : '' }}">
                            A. {{ $question->option_a }}
                        </p>

                        <p class="{{ $question->correct_answer === 'b' ? 'text-success fw-bold' : '' }}">
                            B. {{ $question->option_b }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="{{ $question->correct_answer === 'c' ? 'text-success fw-bold' : '' }}">
                            C. {{ $question->option_c }}
                        </p>

                        <p class="{{ $question->correct_answer === 'd' ? 'text-success fw-bold' : '' }}">
                            D. {{ $question->option_d }}
                        </p>
                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5 text-muted">
                <i class="fa-solid fa-circle-question fa-3x mb-3"></i>

                <h5>No Questions Added Yet</h5>

                <p>
                    Click "Add Question" to create the first question.
                </p>
            </div>

        @endforelse

    </div>

</div>


</div>

@endsection
