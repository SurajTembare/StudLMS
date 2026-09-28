<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentManagementController extends Controller
{
    /**
     * Display all enrollments.
     */
    public function index(Request $request)
    {
        $query = Enrollment::with([
            'user',
            'course'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Search by enrollment ID
                $q->where('id', $search)

                    // Search student
                    ->orWhereHas('user', function ($userQuery) use ($search) {

                        $userQuery
                            ->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');

                    })

                    // Search course
                    ->orWhereHas('course', function ($courseQuery) use ($search) {

                        $courseQuery
                            ->where('title', 'like', '%' . $search . '%');

                    });

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Course Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('course_id')) {

            $query->where(
                'course_id',
                $request->course_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Enrollments
        |--------------------------------------------------------------------------
        */

        $enrollments = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Courses for Filter
        |--------------------------------------------------------------------------
        */

        $courses = Course::orderBy('title')->get();


        /*
        |--------------------------------------------------------------------------
        | Summary Counts
        |--------------------------------------------------------------------------
        */

        $totalEnrollments = Enrollment::count();

        $activeEnrollments = Enrollment::where(
            'status',
            'active'
        )->count();

        $completedEnrollments = Enrollment::where(
            'status',
            'completed'
        )->count();


        return view(
            'admin.enrollments.index',
            compact(
                'enrollments',
                'courses',
                'totalEnrollments',
                'activeEnrollments',
                'completedEnrollments'
            )
        );
    }
}