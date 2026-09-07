@extends('admin.master')

@section('title', 'Edit Quiz Question')

@section('content')

<div class="container-fluid">

```
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Edit Question</h3>
        <p class="text-muted mb-0">
            Quiz: <strong>{{ $quiz->title }}</strong>
        </p>
    </div>

    <a href="{{ route('admin.quiz.questions.index', $quiz->id) }}"
       class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-2"></i>
        Back
    </a>
</div>


<div class="card border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.quiz.questions.update', [
                $quiz->id,
                $question->id
            ]) }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Question --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    Question <span class="text-danger">*</span>
                </label>

                <textarea name="question"
                          rows="3"
                          class="form-control @error('question') is-invalid @enderror">{{ old('question', $question->question) }}</textarea>

                @error('question')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="row">

                {{-- Option A --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Option A <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="option_a"
                           value="{{ old('option_a', $question->option_a) }}"
                           class="form-control @error('option_a') is-invalid @enderror">

                    @error('option_a')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Option B --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Option B <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="option_b"
                           value="{{ old('option_b', $question->option_b) }}"
                           class="form-control @error('option_b') is-invalid @enderror">

                    @error('option_b')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Option C --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Option C <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="option_c"
                           value="{{ old('option_c', $question->option_c) }}"
                           class="form-control @error('option_c') is-invalid @enderror">

                    @error('option_c')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Option D --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Option D <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="option_d"
                           value="{{ old('option_d', $question->option_d) }}"
                           class="form-control @error('option_d') is-invalid @enderror">

                    @error('option_d')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div class="row">

                {{-- Correct Answer --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        Correct Answer <span class="text-danger">*</span>
                    </label>

                    <select name="correct_answer"
                            class="form-select @error('correct_answer') is-invalid @enderror">

                        <option value="a"
                            {{ old('correct_answer', $question->correct_answer) === 'a' ? 'selected' : '' }}>
                            Option A
                        </option>

                        <option value="b"
                            {{ old('correct_answer', $question->correct_answer) === 'b' ? 'selected' : '' }}>
                            Option B
                        </option>

                        <option value="c"
                            {{ old('correct_answer', $question->correct_answer) === 'c' ? 'selected' : '' }}>
                            Option C
                        </option>

                        <option value="d"
                            {{ old('correct_answer', $question->correct_answer) === 'd' ? 'selected' : '' }}>
                            Option D
                        </option>

                    </select>

                    @error('correct_answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Question Order --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold">
                        Question Order <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="question_order"
                           min="1"
                           value="{{ old('question_order', $question->question_order) }}"
                           class="form-control @error('question_order') is-invalid @enderror">

                    @error('question_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                Update Question
            </button>

            <a href="{{ route('admin.quiz.questions.index', $quiz->id) }}"
               class="btn btn-light">
                Cancel
            </a>

        </form>

    </div>
</div>
```

</div>

@endsection
