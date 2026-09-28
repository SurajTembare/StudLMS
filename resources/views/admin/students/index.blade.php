@extends('admin.master')

@section('title', 'Students')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Students
            </h2>

            <p class="text-muted mb-0">
                Manage all enrolled learners
            </p>
        </div>

    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total Students --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-primary bg-opacity-10
                               text-primary d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;"
                    >
                        <i class="fas fa-users"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            Total Students
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $totalStudents }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Enrolled Students --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-success bg-opacity-10
                               text-success d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;"
                    >
                        <i class="fas fa-user-graduate"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            Students With Enrollments
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $studentsWithEnrollments }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- No Enrollment --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div
                        class="rounded-circle bg-warning bg-opacity-10
                               text-warning d-flex align-items-center
                               justify-content-center me-3"
                        style="width:50px;height:50px;"
                    >
                        <i class="fas fa-user-clock"></i>
                    </div>

                    <div>

                        <small class="text-muted">
                            No Enrollments
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $studentsWithoutEnrollments }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Students Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">


            {{-- Search --}}
            <form
                action="{{ route('admin.students.index') }}"
                method="GET"
                class="mb-4"
            >

                <div class="row g-2">

                    <div class="col-md-6">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search student name, email or ID..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            <i class="fas fa-search me-1"></i>
                            Search
                        </button>

                    </div>


                    @if(request('search'))

                        <div class="col-md-2">

                            <a
                                href="{{ route('admin.students.index') }}"
                                class="btn btn-outline-secondary w-100"
                            >
                                <i class="fas fa-times me-1"></i>
                                Clear
                            </a>

                        </div>

                    @endif

                </div>

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
                                Name
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Enrollments
                            </th>

                            <th>
                                Joined
                            </th>

                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($students as $student)

                            <tr>

                                {{-- ID --}}
                                <td>

                                    <span class="fw-semibold">
                                        #{{ $student->id }}
                                    </span>

                                </td>


                                {{-- Name --}}
                                <td>

                                    <div class="d-flex align-items-center">

                                        <div
                                            class="rounded-circle bg-primary text-white
                                                   d-flex align-items-center
                                                   justify-content-center me-2"
                                            style="width:40px;height:40px;"
                                        >
                                            {{ strtoupper(
                                                substr($student->name, 0, 1)
                                            ) }}
                                        </div>

                                        <span class="fw-semibold">
                                            {{ $student->name }}
                                        </span>

                                    </div>

                                </td>


                                {{-- Email --}}
                                <td>

                                    {{ $student->email }}

                                </td>


                                {{-- Role --}}
                                <td>

                                    <span
                                        class="badge bg-primary-subtle text-primary"
                                    >
                                        {{ ucfirst($student->role) }}
                                    </span>

                                </td>


                                {{-- Enrollments --}}
                                <td>

                                    @if($student->enrollments_count > 0)

                                        <span class="badge bg-success">

                                            {{ $student->enrollments_count }}

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            0
                                        </span>

                                    @endif

                                </td>


                                {{-- Joined --}}
                                <td>

                                    {{ $student->created_at
                                        ? $student->created_at->format('d M Y')
                                        : '—'
                                    }}

                                </td>


                                {{-- Action --}}
                                <td class="text-center">

                                    <a
                                        href="{{ route(
                                            'admin.students.show',
                                            $student->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="View Student"
                                    >
                                        <i class="fas fa-eye me-1"></i>
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <i
                                        class="fas fa-users text-muted mb-3"
                                        style="font-size:40px;"
                                    ></i>

                                    <h5 class="fw-bold">
                                        No Students Found
                                    </h5>

                                    <p class="text-muted mb-0">
                                        No students match your search.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($students->hasPages())

                <div class="mt-3">

                    {{ $students->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection