@extends('admin.master')

@section('title', 'Add Lecture')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Add New Lecture</h2>
        <p class="text-muted mb-0">
            Add a video lecture to a course
        </p>
    </div>

    <a href="{{ route('admin.lectures.index') }}"
       class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.lectures.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <!-- Select Course -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Course</label>

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
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Lecture Title -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lecture Title</label>

                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Example: Introduction to Laravel">

                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Video Upload -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Upload Recorded Video
                    </label>

                    <input type="file"
                           name="video"
                           accept="video/*"
                           class="form-control @error('video') is-invalid @enderror">

                    <small class="text-muted">
                        Supported: MP4, WebM, MOV, AVI (Maximum 500 MB)
                    </small>

                    @error('video')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Video URL -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Or Video URL
                    </label>

                    <input type="url"
                           name="video_url"
                           value="{{ old('video_url') }}"
                           class="form-control"
                           placeholder="https://youtube.com/...">
                </div>


                <!-- Lecture Order -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lecture Order</label>

                    <input type="number"
                           name="lecture_order"
                           value="{{ old('lecture_order', 1) }}"
                           min="1"
                           class="form-control">
                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

            </div>


            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Lecture Description</label>

                <textarea name="description"
                          rows="4"
                          class="form-control"
                          placeholder="Write lecture details...">{{ old('description') }}</textarea>
            </div>


            <!-- Document -->
            <div class="mb-4">
                <label class="form-label">
                    Notes / Document (Optional)
                </label>

                <input type="file"
                       name="document"
                       accept=".pdf,.doc,.docx"
                       class="form-control">

                <small class="text-muted">
                    PDF, DOC, DOCX – Maximum 10 MB
                </small>
            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i>
                Save Lecture
            </button>

            <a href="{{ route('admin.lectures.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection