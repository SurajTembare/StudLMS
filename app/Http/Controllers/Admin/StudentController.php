<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LectureProgress;
use App\Models\Certificate;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display all students.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Student Query
        |--------------------------------------------------------------------------
        */

        $query = User::where('role', 'student')
            ->withCount('enrollments');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('id', $search);

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Get Students
        |--------------------------------------------------------------------------
        */

        $students = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Student Summary
        |--------------------------------------------------------------------------
        */

        $totalStudents = User::where(
            'role',
            'student'
        )->count();

        $studentsWithEnrollments = User::where(
            'role',
            'student'
        )
            ->has('enrollments')
            ->count();

        $studentsWithoutEnrollments = User::where(
            'role',
            'student'
        )
            ->doesntHave('enrollments')
            ->count();


        return view(
            'admin.students.index',
            compact(
                'students',
                'totalStudents',
                'studentsWithEnrollments',
                'studentsWithoutEnrollments'
            )
        );
    }


    /**
     * Display student details.
     */
    public function show($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Student
        |--------------------------------------------------------------------------
        */

        $student = User::where('role', 'student')
            ->with([
                'enrollments.course'
            ])
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Enrollment Summary
        |--------------------------------------------------------------------------
        */

        $totalEnrollments = $student->enrollments->count();

        $activeEnrollments = $student->enrollments
            ->where('status', 'active')
            ->count();

        $completedEnrollments = $student->enrollments
            ->where('status', 'completed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Course Progress
        |--------------------------------------------------------------------------
        */

        foreach ($student->enrollments as $enrollment) {

            $course = $enrollment->course;

            if (!$course) {

                $enrollment->progressPercentage = 0;
                $enrollment->completedLectures = 0;
                $enrollment->totalLectures = 0;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Active Lectures
            |--------------------------------------------------------------------------
            */

            $activeLectureIds = $course->lectures()
                ->where('status', 'active')
                ->pluck('id');

            $totalLectures = $activeLectureIds->count();


            /*
            |--------------------------------------------------------------------------
            | Completed Lectures
            |--------------------------------------------------------------------------
            */

            $completedLectures = 0;

            if ($activeLectureIds->isNotEmpty()) {

                $completedLectures = LectureProgress::where(
                    'user_id',
                    $student->id
                )
                    ->where(
                        'course_id',
                        $course->id
                    )
                    ->where(
                        'is_completed',
                        true
                    )
                    ->whereIn(
                        'lecture_id',
                        $activeLectureIds
                    )
                    ->count();
            }


            /*
            |--------------------------------------------------------------------------
            | Progress Percentage
            |--------------------------------------------------------------------------
            */

            if ($enrollment->status === 'completed') {

                $progressPercentage = 100;

            } elseif ($totalLectures > 0) {

                $progressPercentage = round(
                    ($completedLectures / $totalLectures) * 100
                );

                $progressPercentage = min(
                    $progressPercentage,
                    100
                );

            } else {

                $progressPercentage = 0;
            }


            $enrollment->progressPercentage =
                $progressPercentage;

            $enrollment->completedLectures =
                $completedLectures;

            $enrollment->totalLectures =
                $totalLectures;
        }


        /*
        |--------------------------------------------------------------------------
        | Student Certificates
        |--------------------------------------------------------------------------
        */

        $certificates = Certificate::with('course')
            ->where('user_id', $student->id)
            ->latest('issued_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Student Details
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.students.show',
            compact(
                'student',
                'totalEnrollments',
                'activeEnrollments',
                'completedEnrollments',
                'certificates'
            )
        );
    }
}