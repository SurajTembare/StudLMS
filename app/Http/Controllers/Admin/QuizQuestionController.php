<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    /**
     * Show all questions of a quiz.
     */
    public function index($quizId)
    {
        $quiz = Quiz::with('questions')
            ->findOrFail($quizId);

        return view('admin.quizzes.questions.index', compact('quiz'));
    }


    /**
     * Show add question page.
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        return view('admin.quizzes.questions.create', compact('quiz'));
    }


    /**
     * Store question.
     */
    public function store(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'question_order' => 'required|integer|min:1',
        ]);

        $quiz->questions()->create($validated);

        return redirect()
            ->route('admin.quiz.questions.index', $quiz->id)
            ->with('success', 'Question added successfully.');
    }


    /**
     * Show edit question page.
     */
    public function edit($quizId, $questionId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $question = QuizQuestion::where('quiz_id', $quizId)
            ->findOrFail($questionId);

        return view(
            'admin.quizzes.questions.edit',
            compact('quiz', 'question')
        );
    }


    /**
     * Update question.
     */
    public function update(
        Request $request,
        $quizId,
        $questionId
    ) {
        $quiz = Quiz::findOrFail($quizId);

        $question = QuizQuestion::where('quiz_id', $quiz->id)
            ->findOrFail($questionId);

        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
            'question_order' => 'required|integer|min:1',
        ]);

        $question->update($validated);

        return redirect()
            ->route('admin.quiz.questions.index', $quiz->id)
            ->with('success', 'Question updated successfully.');
    }


    /**
     * Delete question.
     */
    public function destroy($quizId, $questionId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $question = QuizQuestion::where('quiz_id', $quiz->id)
            ->findOrFail($questionId);

        $question->delete();

        return redirect()
            ->route('admin.quiz.questions.index', $quiz->id)
            ->with('success', 'Question deleted successfully.');
    }
}
