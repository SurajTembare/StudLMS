@extends('frontend.master')

@section('title', 'Quiz History | ' . $quiz->title)

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <p class="text-muted mb-1">
                {{ $course->title }}
            </p>

            <h2 class="fw-bold mb-1">
                {{ $quiz->title }}
            </h2>

            <p class="text-muted mb-0">
                Your previous quiz attempts
            </p>
        </div>

        <a href="{{ route('student.quiz.start', [
            'courseId' => $course->id,
            'quizId' => $quiz->id
        ]) }}"
            class="btn btn-primary">

            <i class="fa-solid fa-rotate-right me-2"></i>
            Attempt Quiz

        </a>

    </div>


    {{-- Attempts --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h5 class="fw-bold mb-0">
                <i class="fa-solid fa-clock-rotate-left me-2"></i>
                Attempt History
            </h5>

        </div>


        <div class="card-body p-0">

            @if($attempts->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Result</th>
                            <th class="text-end">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($attempts as $index => $attempt)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>

                                @if($attempt->attempted_at)

                                {{ $attempt->attempted_at->format('d M Y') }}

                                <small class="d-block text-muted">
                                    {{ $attempt->attempted_at->format('h:i A') }}
                                </small>

                                @else

                                N/A

                                @endif

                            </td>


                            <td>

                                <strong>
                                    {{ $attempt->correct_answers }}
                                </strong>

                                /
                                {{ $attempt->total_questions }}

                            </td>


                            <td>

                                <strong>
                                    {{ $attempt->percentage }}%
                                </strong>

                            </td>


                            <td>

                                @if($attempt->result === 'pass')

                                <span class="badge bg-success">
                                    <i class="fa-solid fa-check me-1"></i>
                                    Passed
                                </span>

                                @else

                                <span class="badge bg-danger">
                                    <i class="fa-solid fa-xmark me-1"></i>
                                    Failed
                                </span>

                                @endif

                            </td>


                            <td class="text-end">

                                <a href="{{ route('student.quiz.result', [
                                            'courseId' => $course->id,
                                            'quizId' => $quiz->id,
                                            'attemptId' => $attempt->id
                                        ]) }}"
                                    class="btn btn-sm btn-outline-primary">

                                    <i class="fa-solid fa-eye me-1"></i>
                                    View Result

                                </a>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

            <div class="text-center py-5">

                <i class="fa-solid fa-clipboard-question fa-3x text-muted mb-3"></i>

                <h5>
                    No Quiz Attempts Yet
                </h5>

                <p class="text-muted">
                    You haven't attempted this quiz yet.
                </p>

                <a href="{{ route('student.quiz.start', [
                        'courseId' => $course->id,
                        'quizId' => $quiz->id
                    ]) }}"
                    class="btn btn-primary">

                    Start Quiz

                </a>

            </div>

            @endif

        </div>

    </div>


    {{-- Back to Course --}}
    <div class="mt-4">

        <a href="{{ route('course.learn', $course->id) }}"
            class="btn btn-outline-secondary">

            <i class="fa-solid fa-arrow-left me-2"></i>
            Back to Course

        </a>

    </div>

</div>

@endsection