<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::with('category')
            ->latest()
            ->get();

        return view('admin.courses.index', compact('courses'));
    }


    // Show Add Course Page
    public function create()
    {
        $categories = Category::latest()->get();

        return view('admin.courses.create', compact('categories'));
    }


    // Store Course
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'course_type' => 'required|in:free,paid',
            'status' => 'required|in:active,inactive',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $uploadPath = public_path('uploads/courses');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move($uploadPath, $imageName);
        }

        Course::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'image' => $imageName,
            'description' => $request->description,
            'price' => $request->price,
            'course_type' => $request->course_type,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course added successfully!');
    }


    // Show Edit Course Page using ID
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::latest()->get();

        return view(
            'admin.courses.edit',
            compact('course', 'categories')
        );
    }


    // Update Course using ID
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'course_type' => 'required|in:free,paid',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'course_type' => $request->course_type,
            'status' => $request->status,
        ];

        // Upload new image
        if ($request->hasFile('image')) {

            $uploadPath = public_path('uploads/courses');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old image
            if (
                $course->image &&
                File::exists($uploadPath . '/' . $course->image)
            ) {
                File::delete($uploadPath . '/' . $course->image);
            }

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move($uploadPath, $imageName);

            $data['image'] = $imageName;
        }

        $course->update($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }


    // Delete Course using ID
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $imagePath = public_path(
            'uploads/courses/' . $course->image
        );

        if ($course->image && File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Finalize or reopen course content.
     */
    public function toggleContentStatus($id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'content_finalized' => !$course->content_finalized,
        ]);

        return back()->with(
            'success',
            $course->content_finalized
                ? 'Course content has been finalized successfully.'
                : 'Course content has been reopened for editing.'
        );
    }
}
