<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lecture;
use App\Models\LectureProgress;
use App\Models\QuizAttempt;
use App\Models\Certificate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    // Enroll student in a course
    public function enroll($id)
    {
        $course = Course::where('status', 'active')
            ->findOrFail($id);

        // Check if already enrolled
        $alreadyEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()
                ->route('my.learning')
                ->with('info', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'status' => 'active',
        ]);

        return redirect()
            ->route('my.learning')
            ->with('success', 'Successfully enrolled in the course!');
    }


    // Show student's enrolled courses
    public function myLearning()
    {
        // Get all active enrollments of the logged-in student
        $enrollments = Enrollment::with([
            'course.lectures' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('lecture_order');
            }
        ])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['active', 'completed'])
            ->latest()
            ->get();

        // Add progress information to every enrolled course
        foreach ($enrollments as $enrollment) {

            $course = $enrollment->course;

            if (!$course) {
                continue;
            }

            $totalLectures = $course->lectures->count();

            $completedCount = LectureProgress::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();

            $progressPercentage = $totalLectures > 0
                ? round(($completedCount / $totalLectures) * 100)
                : 0;

            // Add temporary progress values to the enrollment object
            $enrollment->totalLectures = $totalLectures;
            $enrollment->completedCount = $completedCount;
            $enrollment->progressPercentage = $progressPercentage;
        }

        return view('frontend.my-learning', compact('enrollments'));
    }

    // Learning page - only for enrolled students
    public function learn($courseId, $lectureId = null)
    {
        // Check that the logged-in student is enrolled
        Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();

        // Get course with active lectures
        $course = Course::with([
            'lectures' => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('lecture_order');
            },
            'quizzes' => function ($query) {
                $query->where('status', 'active');
            },
            'quizzes.questions'
        ])->findOrFail($courseId);

        // Get selected lecture or first lecture
        if ($lectureId) {
            $currentLecture = $course->lectures
                ->where('id', $lectureId)
                ->firstOrFail();
        } else {
            $currentLecture = $course->lectures->first();
        }

        // Get completed lecture IDs for this student
        $completedLectureIds = LectureProgress::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->pluck('lecture_id')
            ->toArray();

        // Calculate progress
        $totalLectures = $course->lectures->count();
        $completedCount = count($completedLectureIds);

        $progressPercentage = $totalLectures > 0
            ? round(($completedCount / $totalLectures) * 100)
            : 0;

        return view('frontend.learn', compact(
            'course',
            'currentLecture',
            'completedLectureIds',
            'completedCount',
            'totalLectures',
            'progressPercentage'
        ));
    }

    public function completeLecture($courseId, $lectureId)
    {
        $userId = Auth::id();


        /*
    |--------------------------------------------------------------------------
    | 1. Verify Student Enrollment
    |--------------------------------------------------------------------------
    */

        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | 2. Get Course with Active Lectures and Quizzes
    |--------------------------------------------------------------------------
    */

        $course = Course::with([

            'lectures' => function ($query) {

                $query->where('status', 'active')
                    ->orderBy('lecture_order');
            },

            'quizzes' => function ($query) {

                $query->where('status', 'active');
            }

        ])->findOrFail($courseId);


        /*
    |--------------------------------------------------------------------------
    | 3. Verify Lecture Belongs to Course
    |--------------------------------------------------------------------------
    */

        $lecture = $course->lectures
            ->where('id', $lectureId)
            ->first();


        if (!$lecture) {

            abort(
                404,
                'Lecture not found in this course.'
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 4. Mark Lecture as Completed
    |--------------------------------------------------------------------------
    */

        LectureProgress::updateOrCreate(

            [
                'user_id' => $userId,
                'course_id' => $courseId,
                'lecture_id' => $lectureId,
            ],

            [
                'is_completed' => true,
                'completed_at' => now(),
            ]

        );


        /*
    |--------------------------------------------------------------------------
    | 5. Count Total Active Lectures
    |--------------------------------------------------------------------------
    */

        $totalLectures = $course->lectures->count();

        $lectureIds = $course->lectures->pluck('id');


        /*
    |--------------------------------------------------------------------------
    | 6. Count Completed Active Lectures
    |--------------------------------------------------------------------------
    */

        $completedLectures = LectureProgress::where(
            'user_id',
            $userId
        )
            ->where(
                'course_id',
                $courseId
            )
            ->where(
                'is_completed',
                true
            )
            ->whereIn(
                'lecture_id',
                $lectureIds
            )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | 7. Check Course Content Finalization
    |--------------------------------------------------------------------------
    */

        $contentFinalized =
            (bool) $course->content_finalized;


        /*
    |--------------------------------------------------------------------------
    | 8. Check All Active Lectures Completed
    |--------------------------------------------------------------------------
    */

        $allLecturesCompleted =
            $totalLectures > 0 &&
            $completedLectures >= $totalLectures;


        /*
    |--------------------------------------------------------------------------
    | 9. Get Active Quizzes
    |--------------------------------------------------------------------------
    */

        $activeQuizzes = $course->quizzes;

        $quizRequired =
            $activeQuizzes->count() > 0;


        /*
    |--------------------------------------------------------------------------
    | 10. Check All Required Quizzes Are Passed
    |--------------------------------------------------------------------------
    */

        $allQuizzesPassed = true;


        if ($quizRequired) {

            foreach ($activeQuizzes as $quiz) {

                $quizPassed = QuizAttempt::where(
                    'quiz_id',
                    $quiz->id
                )
                    ->where(
                        'user_id',
                        $userId
                    )
                    ->where(
                        'result',
                        'pass'
                    )
                    ->exists();


                /*
            | If even one active quiz has not been passed,
            | course completion is not allowed.
            */

                if (!$quizPassed) {

                    $allQuizzesPassed = false;

                    break;
                }
            }
        }


        /*
    |--------------------------------------------------------------------------
    | 11. Check Final Course Completion Requirements
    |--------------------------------------------------------------------------
    |
    | The student can complete the course only when:
    |
    | ✓ Course content is finalized
    | ✓ All active lectures are completed
    | ✓ All required quizzes are passed
    |
    */

        $canCompleteCourse =
            $contentFinalized
            &&
            $allLecturesCompleted
            &&
            (
                !$quizRequired ||
                $allQuizzesPassed
            );


        /*
    |--------------------------------------------------------------------------
    | 12. Update Course Completion Status
    |--------------------------------------------------------------------------
    |
    | Once a student has completed the course,
    | do not change their completion status.
    |
    */

        if (
            $canCompleteCourse &&
            $enrollment->status !== 'completed'
        ) {

            $enrollment->update([

                'status' => 'completed',

                'completed_at' => now(),

            ]);

            Certificate::firstOrCreate(

                [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                ],

                [
                    'certificate_number' =>
                    'CERT-' .
                        strtoupper(Str::random(10)),

                    'issued_at' => now(),
                ]
            );
        }


        /*
    |--------------------------------------------------------------------------
    | 13. Get Fresh Enrollment Status
    |--------------------------------------------------------------------------
    */

        $enrollment = $enrollment->fresh();


        /*
    |--------------------------------------------------------------------------
    | 14. Return JSON for Automatic Video Completion
    |--------------------------------------------------------------------------
    */

        if (request()->expectsJson()) {

            return response()->json([

                'success' => true,

                'course_completed' =>
                $enrollment->status === 'completed',

                'content_finalized' =>
                $contentFinalized,

                'all_lectures_completed' =>
                $allLecturesCompleted,

                'quiz_required' =>
                $quizRequired,

                'all_quizzes_passed' =>
                $allQuizzesPassed,

                'completed_lectures' =>
                $completedLectures,

                'total_lectures' =>
                $totalLectures,

            ]);
        }


        /*
    |--------------------------------------------------------------------------
    | 15. Normal Success Message
    |--------------------------------------------------------------------------
    */

        if ($enrollment->status === 'completed') {

            $message =
                'Congratulations! You have completed this course.';
        } elseif (!$contentFinalized) {

            $message =
                'Lecture marked as completed successfully. Course content is still being updated by the instructor.';
        } elseif (
            $allLecturesCompleted &&
            $quizRequired &&
            !$allQuizzesPassed
        ) {

            $message =
                'All lectures are completed. Please pass all required quizzes to complete this course.';
        } else {

            $message =
                'Lecture marked as completed successfully.';
        }


        return back()->with(
            'success',
            $message
        );
    }
}
