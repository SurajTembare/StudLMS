<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CourseApiController extends Controller
{
    // Get all courses
    public function index()
    {
        $courses = Course::with('category')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Courses fetched successfully',
            'data' => $courses
        ], 200);
    }


    // Get single course
    public function show($id)
    {
        $course = Course::with('category')->find($id);

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Course fetched successfully',
            'data' => $course
        ], 200);
    }


    // Add course
    public function store(Request $request)
    {
        try {

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

                $imageName = time() . '.' .
                    $request->image->extension();

                $request->image->move(
                    $uploadPath,
                    $imageName
                );
            }

            $course = Course::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'image' => $imageName,
                'description' => $request->description,
                'price' => $request->price,
                'course_type' => $request->course_type,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Course added successfully',
                'data' => $course
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Update course
    public function update(Request $request, $id)
    {
        try {

            $course = Course::find($id);

            if (!$course) {
                return response()->json([
                    'status' => false,
                    'message' => 'Course not found'
                ], 404);
            }

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
                    File::makeDirectory(
                        $uploadPath,
                        0755,
                        true
                    );
                }

                // Delete old image
                if (
                    $course->image &&
                    File::exists(
                        $uploadPath . '/' . $course->image
                    )
                ) {
                    File::delete(
                        $uploadPath . '/' . $course->image
                    );
                }

                $imageName = time() . '.' .
                    $request->image->extension();

                $request->image->move(
                    $uploadPath,
                    $imageName
                );

                $data['image'] = $imageName;
            }

            $course->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Course updated successfully',
                'data' => $course
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Delete course
    public function destroy($id)
    {
        try {

            $course = Course::find($id);

            if (!$course) {
                return response()->json([
                    'status' => false,
                    'message' => 'Course not found'
                ], 404);
            }

            // Delete course image
            if ($course->image) {

                $imagePath = public_path(
                    'uploads/courses/' . $course->image
                );

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $course->delete();

            return response()->json([
                'status' => true,
                'message' => 'Course deleted successfully'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}