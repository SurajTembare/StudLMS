<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    // Home Page
    public function index()
    {
        $categories = Category::withCount([
            'courses' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();


        $courses = Course::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.home', compact(
            'categories',
            'courses'
        ));
    }


    // All Courses Page
    public function courses(Request $request)
    {
        $categories = Category::withCount([
            'courses' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();


        $courseQuery = Course::with('category')
            ->where('status', 'active');



        /*
    |--------------------------------------------------------------------------
    | Category Filter
    |--------------------------------------------------------------------------
    */

        if ($request->filled('category_id')) {

            $courseQuery->where(
                'category_id',
                $request->category_id
            );
        }

        // Course search
        if ($request->filled('search')) {
            $courseQuery->where('title', 'like', '%' . $request->search . '%');
        }

         /*
    |--------------------------------------------------------------------------
    | Free / Paid Filter
    |--------------------------------------------------------------------------
    */

    if ($request->filled('course_type')) {

        $courseQuery->where(
            'course_type',
            $request->course_type
        );
    }


    


        $courses = $courseQuery
            ->latest()
            ->get();


        return view('frontend.courses', compact(
            'categories',
            'courses'
        ));
    }


    // Course Details using ID
    public function courseDetails($id)
    {
        // Get active course with category and lectures
        $course = Course::with([
            'category',
            'lectures' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('lecture_order');
            }
        ])
            ->where('status', 'active')
            ->findOrFail($id);

        // Default: student is not enrolled
        $isEnrolled = false;

        // Check enrollment only when user is logged in
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('status', 'active')
                ->exists();
        }

        return view(
            'frontend.course-details',
            compact('course', 'isEnrolled')
        );
    }
}
