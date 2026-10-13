<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Certificate;

class DashboardController extends Controller
{
     public function index()
    {
        // Dashboard statistics
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::count(),
            'activeCourses' => Course::where('status', 'active')->count(),
            'categories' => Category::count(),
            'lectures' => Lecture::count(),
            'enrollments' => Enrollment::count(),
            'quizzes' => Quiz::count(),
            'admins' => User::where('role', 'admin')->count(),

            'activeEnrollments' => Enrollment::where('status', 'active')->count(),
            'completedEnrollments' => Enrollment::where('status', 'completed')->count(),
            'certificates' => Certificate::count(),
        ];

        // Latest registered students
        $recentStudents = User::where('role', 'student')
            ->latest()
            ->take(5)
            ->get();

        // Latest enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        // Latest certificates
        $recentCertificates = Certificate::with(['user', 'course'])
            ->latest('issued_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentStudents',
            'recentEnrollments',
            'recentCertificates'
        ));
    }
}