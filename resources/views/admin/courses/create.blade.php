@extends('admin.master')

@section('title', 'Add Course')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Add New Course</h2>
        <p class="text-muted mb-0">Create a new course for students</p>
    </div>

    <a href="{{ route('admin.courses.index') }}"
       class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form action="{{ route('admin.courses.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="row">

                <!-- Category -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category</label>

                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">-- Select Category --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                           value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Example: Complete Laravel Course">

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Course Image -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        Course Thumbnail (Optional)
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
                            class="form-select @error('course_type') is-invalid @enderror">

                        <option value="free"
                            {{ old('course_type') === 'free' ? 'selected' : '' }}>
                            Free
                        </option>

                        <option value="paid"
                            {{ old('course_type') === 'paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                    </select>

                    @error('course_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Course Price -->
                <div class="col-md-6 mb-3" id="price_section">
                    <label class="form-label">Course Price (₹)</label>

                    <input type="number"
                           name="price"
                           value="{{ old('price', 0) }}"
                           min="0"
                           step="0.01"
                           class="form-control @error('price') is-invalid @enderror"
                           placeholder="Enter course price">

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>

                    <select name="status"
                            class="form-select">

                        <option value="active"
                            {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status') === 'inactive' ? 'selected' : '' }}>
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
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Write complete information about this course">{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i>
                Save Course
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