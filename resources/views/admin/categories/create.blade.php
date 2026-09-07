@extends('admin.master')

@section('title', 'Add Category')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Add Course Category</h2>
    <p class="text-muted">
        Create a new category for your courses
    </p>
</div>

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <form
            action="{{ route('admin.categories.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <!-- Category Name -->
            <div class="mb-3">

                <label class="form-label">
                    Category Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Example: Web Development"
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- Category Image -->
            <div class="mb-3">

                <label class="form-label">
                    Category Image (Optional)
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control @error('image') is-invalid @enderror"
                >

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <button type="submit"
                    class="btn btn-primary">
                <i class="fa-solid fa-save me-1"></i>
                Save Category
            </button>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection