<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::latest()->get();

        return view('admin.categories.index', compact('categories'));
    }


    // Show Add Category Page
    public function create()
    {
        return view('admin.categories.create');
    }


    // Insert Category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('uploads/categories'),
                $imageName
            );
        }

        Category::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category added successfully!');
    }


    // Show Edit Page using ID
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }


    // Update Category using ID
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

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
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('uploads/categories'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }


    // Delete Category using ID
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete image from folder
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

        // Delete category from database
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}