@extends('admin.master')

@section('title', 'Certificates')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="fas fa-certificate text-warning me-2"></i>
                Certificates
            </h3>

            <p class="text-muted mb-0">
                Manage certificates issued to students.
            </p>
        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- Certificate Card --}}
    <div class="card border-0 shadow-sm">

        {{-- Card Header --}}
        <div class="card-header bg-white py-3">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h5 class="mb-0 fw-bold">
                        All Certificates
                    </h5>

                    <small class="text-muted">
                        Total certificates:
                        {{ $certificates->total() }}
                    </small>

                </div>


                {{-- Search --}}
                <div class="col-md-6">

                    <form
                        action="{{ route('admin.certificates.index') }}"
                        method="GET"
                        class="d-flex justify-content-md-end mt-3 mt-md-0"
                    >

                        <div class="input-group"
                             style="max-width: 450px;">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search certificate, student or course..."
                                value="{{ request('search') }}"
                            >

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-search"></i>
                            </button>

                            @if(request('search'))

                                <a
                                    href="{{ route('admin.certificates.index') }}"
                                    class="btn btn-outline-secondary"
                                >
                                    <i class="fas fa-times"></i>
                                </a>

                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- Table --}}
        <div class="card-body p-0">

            @if($certificates->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="px-4">
                                    #
                                </th>

                                <th>
                                    Certificate
                                </th>

                                <th>
                                    Student
                                </th>

                                <th>
                                    Course
                                </th>

                                <th>
                                    Issued Date
                                </th>

                                <th class="text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($certificates as $certificate)

                                <tr>

                                    {{-- Number --}}
                                    <td class="px-4">

                                        {{ $certificates->firstItem() + $loop->index }}

                                    </td>


                                    {{-- Certificate Number --}}
                                    <td>

                                        <span
                                            class="badge bg-light text-dark border px-3 py-2"
                                        >
                                            <i class="fas fa-award text-warning me-1"></i>

                                            {{ $certificate->certificate_number }}

                                        </span>

                                    </td>


                                    {{-- Student --}}
                                    <td>

                                        @if($certificate->user)

                                            <div class="d-flex align-items-center">

                                                <div
                                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                    style="width:40px;height:40px;"
                                                >
                                                    {{ strtoupper(substr($certificate->user->name, 0, 1)) }}
                                                </div>

                                                <div>

                                                    <div class="fw-semibold">
                                                        {{ $certificate->user->name }}
                                                    </div>

                                                    <small class="text-muted">
                                                        {{ $certificate->user->email }}
                                                    </small>

                                                </div>

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                Student unavailable
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Course --}}
                                    <td>

                                        @if($certificate->course)

                                            <span class="fw-semibold">
                                                {{ $certificate->course->title }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                Course unavailable
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Issued Date --}}
                                    <td>

                                        @if($certificate->issued_at)

                                            <div class="fw-semibold">
                                                {{ $certificate->issued_at->format('d M Y') }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $certificate->issued_at->format('h:i A') }}
                                            </small>

                                        @else

                                            <span class="text-muted">
                                                —
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-1">

                                            {{-- View --}}
                                            <a
                                                href="{{ route('admin.certificates.show', $certificate->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="View Certificate"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>


                                            {{-- Download --}}
                                            <a
                                                href="{{ route('admin.certificates.download', $certificate->id) }}"
                                                class="btn btn-sm btn-outline-success"
                                                title="Download Certificate"
                                            >
                                                <i class="fas fa-download"></i>
                                            </a>


                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('admin.certificates.destroy', $certificate->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this certificate?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete Certificate"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="p-3 border-top">

                    {{ $certificates->links() }}

                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-5">

                    <div
                        class="mb-3 d-flex justify-content-center align-items-center"
                        style="
                            width:80px;
                            height:80px;
                            margin:auto;
                            border-radius:50%;
                            background:#fff8e1;
                        "
                    >

                        <i
                            class="fas fa-certificate text-warning"
                            style="font-size:35px;"
                        ></i>

                    </div>


                    @if(request('search'))

                        <h5 class="fw-bold">
                            No certificates found
                        </h5>

                        <p class="text-muted">
                            No certificate matches
                            "{{ request('search') }}".
                        </p>

                        <a
                            href="{{ route('admin.certificates.index') }}"
                            class="btn btn-outline-primary"
                        >
                            <i class="fas fa-arrow-left me-1"></i>
                            Clear Search
                        </a>

                    @else

                        <h5 class="fw-bold">
                            No Certificates Yet
                        </h5>

                        <p class="text-muted mb-0">
                            Certificates will appear here after students
                            complete their courses.
                        </p>

                    @endif

                </div>

            @endif

        </div>

    </div>

</div>

@endsection