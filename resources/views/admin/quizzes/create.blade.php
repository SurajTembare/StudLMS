@extends('admin.master')

@section('title', 'Create Quiz')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Create Quiz</h3>
            <p class="text-muted mb-0">
                Create an assessment for a course.
            </p>
        </div>

        <a href="{{ route('admin.quizzes.index') }}"
           class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Back
        </a>
    </div>


    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.quizzes.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- Select Course --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Select Course <span class="text-danger">*</span>
                        </label>

                        <select name="course_id"
                                class="form-select @error('course_id') is-invalid @enderror">

                            <option value="">-- Select Course --</option>

                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach

                        </select>

                        @error('course_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Quiz Title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Quiz Title <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Example: Laravel Basics Assessment">

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Pass Percentage --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Pass Percentage <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="number"
                                   name="pass_percentage"
                                   value="{{ old('pass_percentage', 40) }}"
                                   min="1"
                                   max="100"
                                   class="form-control @error('pass_percentage') is-invalid @enderror">

                            <span class="input-group-text">%</span>
                        </div>

                        @error('pass_percentage')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror">

                            <option value="active"
                                {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Description --}}
                    <div class="col-12 mb-4">
                        <label class="form-label fw-semibold">
                            Description
                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Enter quiz instructions or description">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Create Quiz
                    </button>

                    <a href="{{ route('admin.quizzes.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection