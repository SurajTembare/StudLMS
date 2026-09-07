<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::count(),
            'activeCourses' => Course::where('status', 'active')->count(),
            'categories' => Category::count(),
            'lectures' => Lecture::count(),
            'enrollments' => Enrollment::count(),
            'quizzes' => Quiz::count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}