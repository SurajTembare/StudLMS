@extends('admin.master')

@section('title', 'Edit Lecture')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Edit Lecture</h2>
        <p class="text-muted mb-0">
            Update lecture information
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

        <form action="{{ route('admin.lectures.update', $lecture->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <!-- Course -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Select Course</label>

                    <select name="course_id"
                            class="form-select @error('course_id') is-invalid @enderror">

                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id', $lecture->course_id) == $course->id ? 'selected' : '' }}>

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


                <!-- Lecture Title -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lecture Title</label>

                    <input type="text"
                           name="title"
                           value="{{ old('title', $lecture->title) }}"
                           class="form-control @error('title') is-invalid @enderror">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Current Video -->
                <div class="col-md-6 mb-3">

                    @if($lecture->video)

                        <label class="form-label d-block">
                            Current Uploaded Video
                        </label>

                        <video width="250"
                               controls
                               class="mb-2 rounded">
                            <source src="{{ asset('uploads/lectures/videos/' . $lecture->video) }}"
                                    type="video/mp4">
                            Your browser does not support video playback.
                        </video>

                    @endif

                    <label class="form-label d-block">
                        Replace Video (Optional)
                    </label>

                    <input type="file"
                           name="video"
                           accept="video/*"
                           class="form-control @error('video') is-invalid @enderror">

                    @error('video')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Video URL -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Video URL (Optional)
                    </label>

                    <input type="url"
                           name="video_url"
                           value="{{ old('video_url', $lecture->video_url) }}"
                           class="form-control"
                           placeholder="https://youtube.com/...">
                </div>


                <!-- Lecture Order -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Lecture Order
                    </label>

                    <input type="number"
                           name="lecture_order"
                           value="{{ old('lecture_order', $lecture->lecture_order) }}"
                           min="1"
                           class="form-control">
                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>

                    <select name="status" class="form-select">

                        <option value="active"
                            {{ old('status', $lecture->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $lecture->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>
                </div>

            </div>


            <!-- Description -->
            <div class="mb-3">

                <label class="form-label">
                    Lecture Description
                </label>

                <textarea name="description"
                          rows="4"
                          class="form-control">{{ old('description', $lecture->description) }}</textarea>

            </div>


            <!-- Current Document -->
            @if($lecture->document)

                <div class="mb-3">

                    <label class="form-label d-block">
                        Current Document
                    </label>

                    <a href="{{ asset('uploads/lectures/documents/' . $lecture->document) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm">

                        <i class="fa-solid fa-file"></i>
                        View Current Document

                    </a>

                </div>

            @endif


            <!-- Replace Document -->
            <div class="mb-4">

                <label class="form-label">
                    Replace Notes / Document (Optional)
                </label>

                <input type="file"
                       name="document"
                       accept=".pdf,.doc,.docx"
                       class="form-control">

            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i>
                Update Lecture
            </button>

            <a href="{{ route('admin.lectures.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection