@extends('admin.master')

@section('title', 'Edit Course')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Edit Course</h2>
        <p class="text-muted mb-0">Update course information</p>
    </div>

    <a href="{{ route('admin.courses.index') }}"
       class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.courses.update', $course->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <!-- Category -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>

                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">-- Select Category --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Course Title -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Title</label>

                    <input type="text"
                           name="title"
                           value="{{ old('title', $course->title) }}"
                           class="form-control @error('title') is-invalid @enderror">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Current Image -->
                <div class="col-md-6 mb-3">

                    @if($course->image)
                        <label class="form-label d-block">
                            Current Thumbnail
                        </label>

                        <img src="{{ asset('uploads/courses/' . $course->image) }}"
                             width="150"
                             height="100"
                             class="rounded mb-2"
                             style="object-fit: cover;">
                    @endif

                    <label class="form-label d-block">
                        Change Course Thumbnail (Optional)
                    </label>

                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Course Type -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Type</label>

                    <select name="course_type"
                            id="course_type"
                            class="form-select">

                        <option value="free"
                            {{ old('course_type', $course->course_type) === 'free' ? 'selected' : '' }}>
                            Free
                        </option>

                        <option value="paid"
                            {{ old('course_type', $course->course_type) === 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                    </select>
                </div>


                <!-- Price -->
                <div class="col-md-6 mb-3" id="price_section">
                    <label class="form-label">Course Price (₹)</label>

                    <input type="number"
                           name="price"
                           value="{{ old('price', $course->price) }}"
                           min="0"
                           step="0.01"
                           class="form-control">
                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>

                    <select name="status"
                            class="form-select">

                        <option value="active"
                            {{ old('status', $course->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $course->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>
                </div>

            </div>


            <!-- Description -->
            <div class="mb-4">
                <label class="form-label">Course Description</label>

                <textarea name="description"
                          rows="5"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $course->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i>
                Update Course
            </button>

            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection


@push('scripts')

<script>
    const courseType = document.getElementById('course_type');
    const priceSection = document.getElementById('price_section');

    function togglePrice() {
        if (courseType.value === 'free') {
            priceSection.style.display = 'none';
        } else {
            priceSection.style.display = 'block';
        }
    }

    courseType.addEventListener('change', togglePrice);

    togglePrice();
</script>

@endpush