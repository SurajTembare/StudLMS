<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display all quizzes.
     */
    public function index()
    {
        $quizzes = Quiz::with('course')
            ->latest()
            ->paginate(10);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Show quiz creation form.
     */
    public function create()
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.quizzes.create', compact('courses'));
    }

    /**
     * Store a new quiz.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Quiz::create($validated);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Show quiz edit form.
     */
    public function edit(Quiz $quiz)
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.quizzes.edit', compact('quiz', 'courses'));
    }

    /**
     * Update quiz.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pass_percentage' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $quiz->update($validated);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Delete quiz.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }
}