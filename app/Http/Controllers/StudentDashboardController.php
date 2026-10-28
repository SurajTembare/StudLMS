<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\LectureProgress;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();

        // Get student's enrollments
        $enrollments = Enrollment::with('course')
            ->where('user_id', $studentId)
            ->latest()
            ->get();

        // Dashboard statistics
        $totalEnrollments = $enrollments->count();

        $activeCourses = $enrollments
            ->where('status', 'active')
            ->count();

        $completedCourses = $enrollments
            ->where('status', 'completed')
            ->count();

        // Calculate progress for each enrolled course
        foreach ($enrollments as $enrollment) {

            $course = $enrollment->course;

            if (!$course) {
                $enrollment->progress_percentage = 0;
                continue;
            }

            // Total active lectures
            $totalLectures = Lecture::where('course_id', $course->id)
                ->where('status', 'active')
                ->count();

            // Completed active lectures for this student
            $completedLectures = LectureProgress::where(
                    'user_id',
                    $studentId
                )
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->whereHas('lecture', function ($query) {
                    $query->where('status', 'active');
                })
                ->count();

            // Calculate percentage
            $progress = $totalLectures > 0
                ? round(($completedLectures / $totalLectures) * 100)
                : 0;

            $enrollment->progress_percentage = max(
                0,
                min(100, (int) $progress)
            );
        }

        // Latest five enrollments
        $recentEnrollments = $enrollments->take(5);

        return view('student.dashboard', compact(
            'enrollments',
            'totalEnrollments',
            'activeCourses',
            'completedCourses',
            'recentEnrollments'
        ));
    }
}


