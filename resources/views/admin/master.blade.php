<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LMS Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --admin-bg: #eef2ff;
            --admin-sidebar: linear-gradient(180deg, #0f172a 0%, #111827 100%);
            --admin-accent: #4f46e5;
            --admin-card: rgba(255, 255, 255, 0.88);
        }

        body {
            background: radial-gradient(circle at top left, rgba(79, 70, 229, 0.12), transparent 22%), #f8fafc;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: var(--admin-sidebar);
            box-shadow: 18px 0 40px rgba(15, 23, 42, 0.12);
        }

        .main-content {
            margin-left: 250px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .8);
            padding: 12px 18px;
            margin: 6px 12px;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(79, 70, 229, 0.18);
            color: white;
            box-shadow: inset 0 0 0 1px rgba(165, 180, 252, 0.35);
        }

        .navbar-white {
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .card,
        .table,
        .alert,
        .form-control,
        .btn,
        .dropdown-menu {
            border-radius: 16px !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white">

        <div class="p-4 border-bottom">
            <h4>
                <i class="fa-solid fa-graduation-cap"></i>
                LMS Admin
            </h4>
        </div>

        <ul class="nav flex-column mt-3">

            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fa-solid fa-gauge me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users me-2"></i>
                    Students
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link">
                    <i class="fa-solid fa-list me-2"></i>
                    Categories
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.courses.index') }}" class="nav-link">
                    <i class="fa-solid fa-book me-2"></i>
                    Courses
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.lectures.index') }}" class="nav-link">
                    <i class="fa-solid fa-video me-2"></i>
                    Lectures
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.quizzes.index') }}"
                    class="nav-link {{ request()->routeIs('admin.quizzes.*') || request()->routeIs('admin.quiz.questions.*') ? 'active' : '' }}">

                    <i class="nav-icon fa-solid fa-file-circle-question"></i>

                    Quizzes
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.enrollments.index') }}" class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-check me-2"></i>
                    Enrollments
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-credit-card me-2"></i>
                    Payments
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-certificate me-2"></i>
                    Certificates
                </a>
            </li>

        </ul>

    </div>


    <!-- Main Content -->
    <div class="main-content">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm px-4">

            <div class="container-fluid">

                <span class="navbar-brand fw-bold">
                    Admin Panel
                </span>

                <div class="dropdown">

                    <button class="btn btn-light dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">

                        <i class="fa-solid fa-user me-1"></i>
                        {{ auth()->user()->name }}

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>


        <!-- Page Content -->
        <main class="p-4">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
            @endif

            @yield('content')

        </main>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>