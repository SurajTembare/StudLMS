@extends('admin.master')

@section('title', 'Enrollments')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Enrollments
            </h2>

            <p class="text-muted mb-0">
                Track learner course enrollments
            </p>
        </div>

    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-primary bg-opacity-10
                               text-primary d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;">
                        <i class="fas fa-users"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            Total Enrollments
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $totalEnrollments }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Active --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-success bg-opacity-10
                               text-success d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;">
                        <i class="fas fa-user-check"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            Active
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $activeEnrollments }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Completed --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-primary bg-opacity-10
                               text-primary d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            Completed
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $completedEnrollments }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Enrollment Table Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">


            {{-- Search & Filters --}}
            <form
                action="{{ route('admin.enrollments.index') }}"
                method="GET"
                class="mb-4">

                <div class="row g-2">

                    {{-- Search --}}
                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search student, email, course or ID..."
                            value="{{ request('search') }}">

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <select
                            name="status"
                            class="form-select">

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="active"
                                {{ request('status') === 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option
                                value="completed"
                                {{ request('status') === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                        </select>

                    </div>


                    {{-- Course --}}
                    <div class="col-md-3">

                        <select
                            name="course_id"
                            class="form-select">

                            <option value="">
                                All Courses
                            </option>

                            @foreach($courses as $course)

                            <option
                                value="{{ $course->id }}"
                                {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Filter --}}
                    <div class="col-md-1">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            title="Filter">
                            <i class="fas fa-search"></i>
                        </button>

                    </div>

                </div>


                {{-- Clear Filters --}}
                @if(
                request('search') ||
                request('status') ||
                request('course_id')
                )

                <div class="mt-2">

                    <a
                        href="{{ route('admin.enrollments.index') }}"
                        class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        Clear Filters
                    </a>

                </div>

                @endif

            </form>


            {{-- Table --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Student
                            </th>

                            <th>
                                Course
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Enrolled At
                            </th>

                            <th>
                                Completed At
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($enrollments as $enrollment)

                        <tr>

                            {{-- ID --}}
                            <td>

                                <span class="fw-semibold">
                                    #{{ $enrollment->id }}
                                </span>

                            </td>


                            {{-- Student --}}
                            <td>

                                @if($enrollment->user)

                                <div>

                                    <div class="fw-semibold">
                                        {{ $enrollment->user->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $enrollment->user->email }}
                                    </small>

                                </div>

                                @else

                                <span class="text-muted">
                                    Unknown Student
                                </span>

                                @endif

                            </td>


                            {{-- Course --}}
                            <td>

                                @if($enrollment->course)

                                <span class="fw-semibold">
                                    {{ $enrollment->course->title }}
                                </span>

                                @else

                                <span class="text-muted">
                                    Course Removed
                                </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($enrollment->status === 'active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                                @elseif($enrollment->status === 'completed')

                                <span class="badge bg-primary">
                                    Completed
                                </span>

                                @elseif($enrollment->status === 'cancelled')

                                <span class="badge bg-danger">
                                    Cancelled
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst($enrollment->status) }}
                                </span>

                                @endif

                            </td>


                            {{-- Enrolled At --}}
                            <td>

                                {{ $enrollment->created_at
                                        ? $enrollment->created_at->format('d M Y')
                                        : '—'
                                    }}

                            </td>


                            {{-- Completed At --}}
                            <td>

                                @if($enrollment->completed_at)

                                <span class="text-success fw-semibold">

                                    {{ $enrollment->completed_at->format('d M Y') }}

                                </span>

                                @else

                                <span class="text-muted">
                                    —
                                </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5">

                                <i
                                    class="fas fa-user-graduate text-muted mb-3"
                                    style="font-size:40px;"></i>

                                <h5 class="fw-bold">
                                    No Enrollments Found
                                </h5>

                                <p class="text-muted mb-0">
                                    There are no enrollments matching
                                    your filters.
                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($enrollments->hasPages())

            <div class="mt-3">

                {{ $enrollments->links() }}

            </div>

            @endif

        </div>

    </div>

</div>

@endsection