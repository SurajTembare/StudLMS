
@extends('admin.master')

@section('title', 'Courses')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-0">Courses</h2>
        <p class="text-muted mb-0">Manage all LMS courses</p>
    </div>

    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>
        Add Course
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Course</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Content Status</th>
                        <th>Action</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($courses as $course)

                        <tr>

                            {{-- ID --}}
                            <td>
                                {{ $course->id }}
                            </td>


                            {{-- Image --}}
                            <td>

                                @if($course->image)

                                    <img
                                        src="{{ asset('uploads/courses/' . $course->image) }}"
                                        width="60"
                                        height="45"
                                        class="rounded"
                                        style="object-fit: cover;"
                                        alt="{{ $course->title }}">

                                @else

                                    <span class="text-muted">
                                        No Image
                                    </span>

                                @endif

                            </td>


                            {{-- Course Title --}}
                            <td class="fw-semibold">

                                {{ $course->title }}

                            </td>


                            {{-- Category --}}
                            <td>

                                {{ $course->category->name ?? 'No Category' }}

                            </td>


                            {{-- Price --}}
                            <td>

                                @if($course->course_type === 'free')

                                    <span class="text-success fw-bold">
                                        Free
                                    </span>

                                @else

                                    ₹{{ number_format($course->price, 2) }}

                                @endif

                            </td>


                            {{-- Course Type --}}
                            <td>

                                <span class="badge bg-info">

                                    {{ ucfirst($course->course_type) }}

                                </span>

                            </td>


                            {{-- Course Status --}}
                            <td>

                                @if($course->status === 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Content Status --}}
                            <td>

                                @if($course->content_finalized)

                                    <span class="badge bg-success">

                                        <i class="fa-solid fa-circle-check me-1"></i>
                                        Content Finalized

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">

                                        <i class="fa-solid fa-pen me-1"></i>
                                        Content In Progress

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="text-nowrap">

                                {{-- Edit --}}
                                <a
                                    href="{{ route('admin.courses.edit', $course->id) }}"
                                    class="btn btn-sm btn-warning"
                                    title="Edit Course">

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                {{-- Finalize / Reopen --}}
                                <form
                                    action="{{ route('admin.courses.toggle-content-status', $course->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf


                                    @if($course->content_finalized)

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-warning"
                                            title="Reopen Content"
                                            onclick="return confirm('Are you sure you want to reopen this course content?')">

                                            <i class="fa-solid fa-lock-open"></i>

                                        </button>

                                    @else

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-success"
                                            title="Finalize Content"
                                            onclick="return confirm('Are you sure you have added all required lectures?')">

                                            <i class="fa-solid fa-lock"></i>

                                        </button>

                                    @endif

                                </form>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('admin.courses.destroy', $course->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this course?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Delete Course">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="text-center py-4 text-muted">

                                No courses found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

