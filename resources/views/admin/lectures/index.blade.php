@extends('admin.master')

@section('title', 'Lectures')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Lectures</h2>
        <p class="text-muted mb-0">Manage all course lectures</p>
    </div>

    <a href="{{ route('admin.lectures.create') }}"
       class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>
        Add Lecture
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
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
                        <th>Lecture Title</th>
                        <th>Course</th>
                        <th>Order</th>
                        <th>Video</th>
                        <th>Document</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($lectures as $lecture)

                        <tr>
                            <td>{{ $lecture->id }}</td>

                            <td class="fw-semibold">
                                {{ $lecture->title }}
                            </td>

                            <td>
                                {{ $lecture->course->title ?? 'No Course' }}
                            </td>

                            <td>
                                {{ $lecture->lecture_order }}
                            </td>

                            <!-- Video -->
                            <td>
                                @if($lecture->video)
                                    <span class="badge bg-success">
                                        Uploaded Video
                                    </span>
                                @elseif($lecture->video_url)
                                    <a href="{{ $lecture->video_url }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-play"></i>
                                        View URL
                                    </a>
                                @else
                                    <span class="text-muted">
                                        No Video
                                    </span>
                                @endif
                            </td>

                            <!-- Document -->
                            <td>
                                @if($lecture->document)
                                    <a href="{{ asset('uploads/lectures/documents/' . $lecture->document) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fa-solid fa-file"></i>
                                        View
                                    </a>
                                @else
                                    <span class="text-muted">
                                        No Document
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($lecture->status === 'active')
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td>

                                <a href="{{ route('admin.lectures.edit', $lecture->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.lectures.destroy', $lecture->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this lecture?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="text-center py-4 text-muted">
                                No lectures found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection