@extends('admin.master')

@section('title', 'Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Course Categories</h2>
        <p class="text-muted mb-0">Manage all course categories</p>
    </div>

    <a href="{{ route('admin.categories.create') }}"
       class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>
        Add Category
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)

                        <tr>
                            <td>{{ $category->id }}</td>

                            <td>
                                @if($category->image)
                                    <img
                                        src="{{ asset('uploads/categories/' . $category->image) }}"
                                        width="50"
                                        height="50"
                                        class="rounded"
                                        style="object-fit: cover;"
                                    >
                                @else
                                    <span class="text-muted">
                                        No Image
                                    </span>
                                @endif
                            </td>

                            <td class="fw-semibold">
                                {{ $category->name }}
                            </td>

                            <td>
                                {{ $category->created_at->format('d M Y') }}
                            </td>

                            <td class="text-end">

                                <!-- Edit -->
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen"></i>
                                </a>


                                <!-- Delete -->
                                <form
                                    action="{{ route('admin.categories.destroy', $category->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this category?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5"
                                class="text-center py-4 text-muted">
                                No categories found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection