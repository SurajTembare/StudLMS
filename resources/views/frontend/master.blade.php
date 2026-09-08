<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Student LMS')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-dark: #0f172a;
            --brand-soft: #eef2ff;
            --brand-card: #ffffff;
            --brand-muted: #64748b;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(79, 70, 229, 0.12), transparent 28%),
                linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f8fafc 100%);
            color: var(--brand-dark);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(12px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.45rem;
            letter-spacing: -0.03em;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.82) !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .navbar .nav-link:hover {
            color: #fff !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-primary), #7c3aed);
            border: none;
            box-shadow: 0 12px 20px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
        }

        .btn-outline-light {
            border-width: 1.5px;
            font-weight: 600;
        }

        .page-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 42%, #4f46e5 100%);
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 24%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 999px;
            color: #f8fafc;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .float-card {
            position: relative;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.18);
        }

        .course-card {
            border: 1px solid rgba(148, 163, 184, 0.15);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 18px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }

        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.12);
        }

        .course-image {
            height: 210px;
            width: 100%;
            object-fit: cover;
        }

        .course-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: rgba(79, 70, 229, 0.08);
            color: #4338ca;
        }

        .feature-card,
        .info-card,
        .lecture-item,
        .card {
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        .lecture-item {
            background: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .lecture-item:hover {
            transform: translateX(3px);
            box-shadow: 0 14px 28px rgba(79, 70, 229, 0.08);
        }

        .premium-footer {
            background: linear-gradient(180deg, #0f172a 0%, #020817 100%);
            color: rgba(255, 255, 255, 0.8);
        }

        .premium-footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
        }

        .premium-footer a:hover {
            color: #fff;
        }

        footer {
            margin-top: 90px;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">

            <a class="navbar-brand"
                href="{{ route('home') }}">
                <i class="fa-solid fa-graduation-cap me-2"></i>
                Student LMS
            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse"
                id="navbarMenu">

                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('courses') }}">
                            Courses
                        </a>
                    </li>





                    @guest
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-light btn-sm">
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('register') }}"
                            class="btn btn-primary btn-sm">
                            Register
                        </a>
                    </li>
                    @endguest

                    @auth

                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('my.learning') }}">
                            <i class="fa-solid fa-book-open me-1"></i>
                            My Learning
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('student.certificates.index') }}">

                            <i class="fa-solid fa-certificate me-2"></i>

                            My Certificates

                        </a>
                    </li>


                    <li class="nav-item ms-lg-3">
                        <span class="text-white me-2">
                            Hi, {{ Auth::user()->name }}
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST"
                            action="{{ route('logout') }}">
                            @csrf

                            <button class="btn btn-outline-light btn-sm">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <main>
        @yield('content')
    </main>


    <!-- Footer -->
    <footer class="premium-footer text-white py-5">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <a class="navbar-brand text-white d-inline-block mb-3" href="{{ route('home') }}">
                        <i class="fa-solid fa-graduation-cap me-2"></i>
                        Student LMS
                    </a>
                    <p class="text-white-50 mb-0">
                        Learn faster, build real-world skills, and turn knowledge into momentum with a premium learning experience.
                    </p>

                    <a href="{{ route('certificate.verify.form') }}">
                        <i class="fa-solid fa-shield-check me-1"></i>
                        Verify Certificate
                    </a>
                </div>

                <div class="col-md-4 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Company</h6>
                    <ul class="list-unstyled m-0">
                        <li class="mb-2"><a href="{{ route('home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('courses') }}">Courses</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3">
                    <h6 class="fw-bold text-white mb-3">Explore</h6>
                    <ul class="list-unstyled m-0">
                        <li class="mb-2"><a href="#">Career Tracks</a></li>
                        <li class="mb-2"><a href="#">Learning Paths</a></li>
                        <li><a href="#">Certificates</a></li>
                    </ul>
                </div>

                <div class="col-md-4 col-lg-3">
                    <h6 class="fw-bold text-white mb-3">Support</h6>
                    <ul class="list-unstyled m-0">
                        <li class="mb-2"><a href="#">Help Center</a></li>
                        <li class="mb-2"><a href="#">Community</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-top border-white-10 mt-4 pt-4 text-center text-white-50">
                © {{ date('Y') }} Student LMS. All Rights Reserved.
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>