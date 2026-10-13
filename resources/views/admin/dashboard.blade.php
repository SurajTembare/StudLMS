@extends('admin.master')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-black mb-1">Admin Dashboard</h2>
        <p class="text-muted mb-0">
            Welcome back, {{ auth()->user()->name }}! Here is your LMS overview.
        </p>
    </div>
    <span class="badge bg-primary-subtle text-primary px-3 py-2">System Online</span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(255,255,255,0.9));">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Students</p>
                        <h3 class="fw-bold mb-0">{{ $stats['students'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-primary-subtle text-primary p-3 fs-4">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(255,255,255,0.9));">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Courses</p>
                        <h3 class="fw-bold mb-0">{{ $stats['courses'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-success-subtle text-success p-3 fs-4">
                        <i class="fa-solid fa-book"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(255,255,255,0.9));">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Enrollments</p>
                        <h3 class="fw-bold mb-0">{{ $stats['enrollments'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-warning-subtle text-warning p-3 fs-4">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, rgba(239,68,68,0.12), rgba(255,255,255,0.9));">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Categories</p>
                        <h3 class="fw-bold mb-0">{{ $stats['categories'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-danger-subtle text-danger p-3 fs-4">
                        <i class="fa-solid fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Lectures</p>
                        <h3 class="fw-bold mb-0">{{ $stats['lectures'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-info-subtle text-info p-3 fs-4">
                        <i class="fa-solid fa-video"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Quizzes</p>
                        <h3 class="fw-bold mb-0">{{ $stats['quizzes'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-secondary-subtle text-secondary p-3 fs-4">
                        <i class="fa-solid fa-file-circle-question"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Active Courses</p>
                        <h3 class="fw-bold mb-0">{{ $stats['activeCourses'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-success-subtle text-success p-3 fs-4">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Admins</p>
                        <h3 class="fw-bold mb-0">{{ $stats['admins'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-dark-subtle text-dark p-3 fs-4">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Platform Overview</h4>
                <span class="badge bg-primary-subtle text-primary px-3 py-2">Live</span>
            </div>

            <div class="p-4 rounded-4 border border-primary-subtle bg-primary-subtle">
                <div class="text-primary fw-semibold mb-2">Learning Platform Status</div>
                <div class="display-6 fw-black text-primary">Healthy</div>
                <p class="text-muted mb-0 mt-2">
                    Your LMS is active with {{ $stats['courses'] }} courses, {{ $stats['lectures'] }} lectures, and {{ $stats['enrollments'] }} recorded enrollments.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Quick Insights</h4>
                <span class="badge bg-success-subtle text-success px-3 py-2">Updated</span>
            </div>

            <div class="d-grid gap-3">
                <div class="rounded-4 border border-light bg-light p-3">
                    <div class="text-muted small mb-1">Course coverage</div>
                    <div class="fw-bold fs-5">{{ $stats['categories'] }} categories</div>
                </div>

                <div class="rounded-4 border border-light bg-light p-3">
                    <div class="text-muted small mb-1">Assessment activity</div>
                    <div class="fw-bold fs-5">{{ $stats['quizzes'] }} quizzes created</div>
                </div>

                <div class="rounded-4 border border-light bg-light p-3">
                    <div class="text-muted small mb-1">Student engagement</div>
                    <div class="fw-bold fs-5">{{ $stats['students'] }} registered learners</div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Additional Dashboard Statistics --}}
<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <p class="text-muted mb-1">Active Enrollments</p>
                <h3 class="fw-bold text-success mb-0">
                    {{ $stats['activeEnrollments'] }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <p class="text-muted mb-1">Completed Enrollments</p>
                <h3 class="fw-bold text-primary mb-0">
                    {{ $stats['completedEnrollments'] }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="card-body">
                <p class="text-muted mb-1">Certificates Issued</p>
                <h3 class="fw-bold text-warning mb-0">
                    {{ $stats['certificates'] }}
                </h3>
            </div>
        </div>
    </div>

</div>


{{-- Recent Students --}}
<div class="row g-4 mb-4">

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-users text-primary me-2"></i>
                    Recent Students
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-3">Student</th>
                                <th>Email</th>
                                <th>Registered</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentStudents as $student)
                                <tr>
                                    <td class="px-3">
                                        <div class="fw-semibold">
                                            {{ $student->name }}
                                        </div>
                                    </td>

                                    <td>
                                        <small>{{ $student->email }}</small>
                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            {{ $student->created_at?->format('d M Y') ?? '—' }}
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="text-center text-muted py-4">
                                        No students registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>


    {{-- Recent Enrollments --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-user-check text-success me-2"></i>
                    Recent Enrollments
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-3">Student</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentEnrollments as $enrollment)
                                <tr>
                                    <td class="px-3">
                                        <div class="fw-semibold">
                                            {{ $enrollment->user->name ?? 'Student Removed' }}
                                        </div>
                                    </td>

                                    <td>
                                        <small>
                                            {{ $enrollment->course->title ?? 'Course Removed' }}
                                        </small>
                                    </td>

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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="text-center text-muted py-4">
                                        No enrollments yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

</div>


{{-- Recent Certificates --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="fa-solid fa-certificate text-warning me-2"></i>
            Recently Issued Certificates
        </h5>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="px-3">Certificate Number</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Issued Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentCertificates as $certificate)
                        <tr>
                            <td class="px-3">
                                <span class="fw-semibold">
                                    {{ $certificate->certificate_number }}
                                </span>
                            </td>

                            <td>
                                {{ $certificate->user->name ?? 'Student Removed' }}
                            </td>

                            <td>
                                {{ $certificate->course->title ?? 'Course Removed' }}
                            </td>

                            <td>
                                {{ $certificate->issued_at
                                    ? $certificate->issued_at->format('d M Y')
                                    : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                class="text-center text-muted py-4">
                                No certificates issued yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection