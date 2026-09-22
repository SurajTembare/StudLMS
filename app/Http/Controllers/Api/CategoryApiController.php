<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    // Get all categories
    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'status' => true,
                'message' => 'Categories fetched successfully',
                'data' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Get single category
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category fetched successfully',
            'data' => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $category = new Category();

        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/categories'), $imageName);

            $category->image = $imageName;
        }

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category added successfully',
            'data' => $category
        ], 201);
    }

    // Update Category
    public function update(Request $request, $id)
    {
        try {

            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // Update category name
            $category->name = $request->name;

            // Check if new image is uploaded
            if ($request->hasFile('image')) {

                // Delete old image
                if (
                    $category->image &&
                    file_exists(
                        public_path('uploads/categories/' . $category->image)
                    )
                ) {
                    unlink(
                        public_path('uploads/categories/' . $category->image)
                    );
                }

                // Upload new image
                $image = $request->file('image');

                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('uploads/categories'),
                    $imageName
                );

                $category->image = $imageName;
            }

            // Save category
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Delete category image if exists
            if (
                $category->image &&
                file_exists(
                    public_path('uploads/categories/' . $category->image)
                )
            ) {
                unlink(
                    public_path('uploads/categories/' . $category->image)
                );
            }

            // Delete category
            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully'
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
