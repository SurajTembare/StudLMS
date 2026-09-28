@extends('admin.master')

@section('title', 'Student Details')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Student Details
            </h2>

            <p class="text-muted mb-0">
                View student profile, enrollments and certificates.
            </p>
        </div>

        <a href="{{ route('admin.students.index') }}"
           class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-1"></i>
            Back to Students

        </a>

    </div>


    {{-- Student Profile --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex align-items-center">

                <div class="rounded-circle bg-primary text-white
                            d-flex align-items-center justify-content-center me-3"
                     style="width:75px;height:75px;font-size:30px;">

                    {{ strtoupper(substr($student->name, 0, 1)) }}

                </div>

                <div>

                    <h3 class="fw-bold mb-1">
                        {{ $student->name }}
                    </h3>

                    <p class="text-muted mb-1">
                        <i class="fas fa-envelope me-2"></i>
                        {{ $student->email }}
                    </p>

                    <small class="text-muted">

                        <i class="fas fa-calendar me-1"></i>

                        Joined
                        {{ $student->created_at ? $student->created_at->format('d M Y') : '—' }}

                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        {{-- Total --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Total Enrollments
                    </small>

                    <h3 class="fw-bold mb-0">
                        {{ $totalEnrollments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Active --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Active Courses
                    </small>

                    <h3 class="fw-bold text-success mb-0">
                        {{ $activeEnrollments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Completed --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Completed Courses
                    </small>

                    <h3 class="fw-bold text-primary mb-0">
                        {{ $completedEnrollments }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Course Enrollments --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="fas fa-book-open me-2 text-primary"></i>

                Course Enrollments

            </h5>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                Course
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Progress
                            </th>

                            <th>
                                Enrolled
                            </th>

                            <th>
                                Completed
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($student->enrollments as $enrollment)

                            <tr>

                                {{-- Course --}}
                                <td class="px-4">

                                    @if($enrollment->course)

                                        <div class="fw-semibold">
                                            {{ $enrollment->course->title }}
                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Course Removed
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($enrollment->status === 'completed')

                                        <span class="badge bg-primary">
                                            Completed
                                        </span>

                                    @elseif($enrollment->status === 'active')

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Progress --}}
                                <td style="min-width:180px;">

                                    <div class="d-flex justify-content-between mb-1">

                                        <small class="text-muted">
                                            Progress
                                        </small>

                                        <small class="fw-semibold">
                                            {{ $enrollment->progressPercentage }}%
                                        </small>

                                    </div>


                                    <div class="progress" style="height:7px;">

                                        <div
                                            class="progress-bar {{ $enrollment->status === 'completed' ? 'bg-primary' : 'bg-success' }}"
                                            style="width: {{ $enrollment->progressPercentage }}%;">
                                        </div>

                                    </div>

                                </td>


                                {{-- Enrolled Date --}}
                                <td>

                                    {{ $enrollment->created_at
                                        ? $enrollment->created_at->format('d M Y')
                                        : '—' }}

                                </td>


                                {{-- Completed Date --}}
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

                                <td colspan="5"
                                    class="text-center py-5 text-muted">

                                    <i class="fas fa-book-open mb-2"
                                       style="font-size:35px;">
                                    </i>

                                    <p class="mb-0">
                                        This student has no enrollments.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Certificates --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                <i class="fas fa-certificate me-2 text-warning"></i>

                Certificates

            </h5>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                Certificate Number
                            </th>

                            <th>
                                Course
                            </th>

                            <th>
                                Issued Date
                            </th>

                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($certificates as $certificate)

                            <tr>

                                {{-- Certificate Number --}}
                                <td class="px-4">

                                    <span class="fw-semibold">
                                        {{ $certificate->certificate_number }}
                                    </span>

                                </td>


                                {{-- Course --}}
                                <td>

                                    {{ $certificate->course
                                        ? $certificate->course->title
                                        : 'Course Removed' }}

                                </td>


                                {{-- Issued Date --}}
                                <td>

                                    @if($certificate->issued_at)

                                        {{ $certificate->issued_at->format('d M Y') }}

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="text-center">

                                    <a href="{{ route('admin.certificates.show', $certificate->id) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        <i class="fas fa-eye me-1"></i>
                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-4 text-muted">

                                    <i class="fas fa-certificate me-2"></i>

                                    No certificates earned yet.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection