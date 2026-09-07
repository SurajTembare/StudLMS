<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Enrollment;
use App\Models\LectureProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAttemptController extends Controller
{
    /**
     * Show quiz to enrolled student
     */
    public function start($courseId, $quizId)
    {
        $userId = Auth::id();

        // Check student enrollment
        Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();

        // Get course
        $course = Course::findOrFail($courseId);

        // Get active quiz belonging to this course
        $quiz = Quiz::with([
            'questions' => function ($query) {
                $query->orderBy('question_order');
            }
        ])
            ->where('id', $quizId)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->firstOrFail();

        // Make sure quiz has questions
        if ($quiz->questions->count() === 0) {

            return redirect()
                ->route('course.learn', $courseId)
                ->with(
                    'error',
                    'This quiz does not have any questions yet.'
                );
        }

        return view(
            'frontend.quiz.start',
            compact('course', 'quiz')
        );
    }


    /**
     * Submit quiz
     */

    public function submit(Request $request, $courseId, $quizId)
    {
        $userId = Auth::id();


        /*
    |--------------------------------------------------------------------------
    | 1. Verify Enrollment
    |--------------------------------------------------------------------------
    */

        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | 2. Get Quiz With Questions
    |--------------------------------------------------------------------------
    */

        $quiz = Quiz::with('questions')
            ->where('id', $quizId)
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | 3. Validate Answers
    |--------------------------------------------------------------------------
    */

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:a,b,c,d',
        ]);


        /*
    |--------------------------------------------------------------------------
    | 4. Get Questions
    |--------------------------------------------------------------------------
    */

        $questions = $quiz->questions;

        $totalQuestions = $questions->count();

        $correctAnswers = 0;


        /*
    |--------------------------------------------------------------------------
    | 5. Check Student Answers
    |--------------------------------------------------------------------------
    */

        foreach ($questions as $question) {

            $studentAnswer = $request->input(
                'answers.' . $question->id
            );

            if ($studentAnswer === $question->correct_answer) {

                $correctAnswers++;
            }
        }


        /*
    |--------------------------------------------------------------------------
    | 6. Calculate Percentage
    |--------------------------------------------------------------------------
    */

        $percentage = $totalQuestions > 0
            ? round(
                ($correctAnswers / $totalQuestions) * 100,
                2
            )
            : 0;


        /*
    |--------------------------------------------------------------------------
    | 7. Determine Pass / Fail
    |--------------------------------------------------------------------------
    */

        $result = $percentage >= $quiz->pass_percentage
            ? 'pass'
            : 'fail';


        /*
    |--------------------------------------------------------------------------
    | 8. Save Quiz Attempt
    |--------------------------------------------------------------------------
    */

        $attempt = QuizAttempt::create([

            'quiz_id' => $quiz->id,

            'user_id' => $userId,

            'total_questions' => $totalQuestions,

            'correct_answers' => $correctAnswers,

            'percentage' => $percentage,

            'result' => $result,

            'attempted_at' => now(),

        ]);


        /*
    |--------------------------------------------------------------------------
    | 9. Get Course With Active Lectures and Quizzes
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
    | 10. Count Active Lectures
    |--------------------------------------------------------------------------
    */

        $totalLectures = $course->lectures->count();

        $lectureIds = $course->lectures->pluck('id');


        /*
    |--------------------------------------------------------------------------
    | 11. Count Completed Active Lectures
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
    | 12. Check All Active Lectures Completed
    |--------------------------------------------------------------------------
    */

        $allLecturesCompleted =
            $totalLectures > 0 &&
            $completedLectures >= $totalLectures;


        /*
    |--------------------------------------------------------------------------
    | 13. Check Whether Course Has Quizzes
    |--------------------------------------------------------------------------
    */

        $activeQuizzes = $course->quizzes;

        $quizRequired = $activeQuizzes->count() > 0;


        /*
    |--------------------------------------------------------------------------
    | 14. Check Whether Required Quizzes Are Passed
    |--------------------------------------------------------------------------
    */

        $allQuizzesPassed = true;


        if ($quizRequired) {

            foreach ($activeQuizzes as $activeQuiz) {

                $quizPassed = QuizAttempt::where(
                    'quiz_id',
                    $activeQuiz->id
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
            | If even one required quiz is not passed,
            | the course requirements are incomplete.
            */

                if (!$quizPassed) {

                    $allQuizzesPassed = false;

                    break;
                }
            }
        }


        /*
    |--------------------------------------------------------------------------
    | 15. Check Final Course Requirements
    |--------------------------------------------------------------------------
    |
    | The course is completed only when:
    |
    | ✓ Admin has finalized course content
    | ✓ Student completed all active lectures
    | ✓ Student passed all required quizzes
    |
    */

        $canCompleteCourse =
            $course->content_finalized
            &&
            $allLecturesCompleted
            &&
            (
                !$quizRequired ||
                $allQuizzesPassed
            );


        /*
    |--------------------------------------------------------------------------
    | 16. Complete Course
    |--------------------------------------------------------------------------
    */

        $courseCompleted = false;


        if (
            $canCompleteCourse &&
            $enrollment->status !== 'completed'
        ) {

            $enrollment->update([

                'status' => 'completed',

                'completed_at' => now(),

            ]);


            $courseCompleted = true;
        } elseif ($enrollment->status === 'completed') {

            /*
        |--------------------------------------------------------------------------
        | Student Already Completed Course
        |--------------------------------------------------------------------------
        |
        | Never remove or change their original completion date.
        |
        */

            $courseCompleted = true;
        }


        /*
    |--------------------------------------------------------------------------
    | 17. Redirect to Quiz Result
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route('student.quiz.result', [

                'courseId' => $courseId,

                'quizId' => $quizId,

                'attemptId' => $attempt->id,

            ])
            ->with(
                'course_completed',
                $courseCompleted
            );
    }






    /**
     * Show quiz result
     */
    public function result($courseId, $quizId, $attemptId)
    {
        $userId = Auth::id();


        // Verify enrollment
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();


        // Verify quiz belongs to course
        $quiz = Quiz::where('id', $quizId)
            ->where('course_id', $courseId)
            ->firstOrFail();


        // Only allow student to see their own result
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('quiz_id', $quizId)
            ->where('user_id', $userId)
            ->firstOrFail();


        $course = Course::findOrFail($courseId);


        return view(
            'frontend.quiz.result',
            compact(
                'course',
                'quiz',
                'attempt',
                'enrollment'
            )
        );
    }


    /**
     * Quiz Attempt History
     */
    public function history($courseId, $quizId)
    {
        $userId = Auth::id();


        // Check student enrollment
        Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', ['active', 'completed'])
            ->firstOrFail();


        // Verify quiz belongs to the course
        $quiz = Quiz::where('id', $quizId)
            ->where('course_id', $courseId)
            ->firstOrFail();


        // Get only this student's attempts
        $attempts = QuizAttempt::where(
            'quiz_id',
            $quizId
        )
            ->where('user_id', $userId)
            ->latest('attempted_at')
            ->get();


        $course = Course::findOrFail($courseId);


        return view(
            'frontend.quiz.history',
            compact(
                'course',
                'quiz',
                'attempts'
            )
        );
    }
}
