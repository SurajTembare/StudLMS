@extends('admin.master')

@section('title', 'Edit Category')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Edit Course Category</h2>
    <p class="text-muted">
        Update category information
    </p>
</div>

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <form
            action="{{ route('admin.categories.update', $category->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div class="mb-3">

                <label class="form-label">
                    Category Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- Current Image -->
            @if($category->image)

                <div class="mb-3">

                    <label class="form-label d-block">
                        Current Image
                    </label>

                    <img
                        src="{{ asset('uploads/categories/' . $category->image) }}"
                        width="100"
                        height="100"
                        class="rounded mb-2"
                        style="object-fit: cover;"
                    >

                </div>

            @endif


            <!-- New Image -->
            <div class="mb-3">

                <label class="form-label">
                    Change Image (Optional)
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
                Update Category
            </button>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@endsection