<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class EnrollmentManagementController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->get();

        return view('admin.enrollments.index', compact('enrollments'));
    }
}
