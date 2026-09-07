<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LectureController extends Controller
{
    // Show all lectures
    public function index()
    {
        $lectures = Lecture::with('course')
            ->orderBy('course_id')
            ->orderBy('lecture_order')
            ->get();

        return view('admin.lectures.index', compact('lectures'));
    }


    // Show Add Lecture Page
    public function create()
    {
        $courses = Course::where('status', 'active')
            ->latest()
            ->get();

        return view('admin.lectures.create', compact('courses'));
    }


    // Store Lecture
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',

            // Recorded video from device
            'video' => 'nullable|file|mimes:mp4,webm,mov,avi|max:512000',

            'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
            'lecture_order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $videoName = null;
        $documentName = null;

        // Upload Recorded Video
        if ($request->hasFile('video')) {

            $videoPath = public_path('uploads/lectures/videos');

            if (!File::exists($videoPath)) {
                File::makeDirectory($videoPath, 0755, true);
            }

            $videoName = time() . '_' .
                $request->video->getClientOriginalName();

            $request->video->move(
                $videoPath,
                $videoName
            );
        }

        // Upload Document
        if ($request->hasFile('document')) {

            $documentPath = public_path('uploads/lectures/documents');

            if (!File::exists($documentPath)) {
                File::makeDirectory($documentPath, 0755, true);
            }

            $documentName = time() . '_' .
                $request->document->getClientOriginalName();

            $request->document->move(
                $documentPath,
                $documentName
            );
        }

        Lecture::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'video' => $videoName,
            'document' => $documentName,
            'lecture_order' => $request->lecture_order,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.lectures.index')
            ->with('success', 'Lecture added successfully!');
    }


    // Show Edit Lecture Page using ID
    public function edit($id)
    {
        $lecture = Lecture::findOrFail($id);

        $courses = Course::where('status', 'active')
            ->latest()
            ->get();

        return view(
            'admin.lectures.edit',
            compact('lecture', 'courses')
        );
    }


    // Update Lecture using ID
    public function update(Request $request, $id)
    {
        $lecture = Lecture::findOrFail($id);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url|max:500',
            'video' => 'nullable|file|mimes:mp4,webm,mov,avi|max:512000',
            'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
            'lecture_order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
            'lecture_order' => $request->lecture_order,
            'status' => $request->status,
        ];

        // Upload New Video
        if ($request->hasFile('video')) {

            $videoPath = public_path('uploads/lectures/videos');

            if (!File::exists($videoPath)) {
                File::makeDirectory($videoPath, 0755, true);
            }

            // Delete old video
            if (
                $lecture->video &&
                File::exists($videoPath . '/' . $lecture->video)
            ) {
                File::delete($videoPath . '/' . $lecture->video);
            }

            $videoName = time() . '_' .
                $request->video->getClientOriginalName();

            $request->video->move($videoPath, $videoName);

            $data['video'] = $videoName;
        }

        // Upload New Document
        if ($request->hasFile('document')) {

            $documentPath = public_path('uploads/lectures/documents');

            if (!File::exists($documentPath)) {
                File::makeDirectory($documentPath, 0755, true);
            }

            // Delete old document
            if (
                $lecture->document &&
                File::exists($documentPath . '/' . $lecture->document)
            ) {
                File::delete(
                    $documentPath . '/' . $lecture->document
                );
            }

            $documentName = time() . '_' .
                $request->document->getClientOriginalName();

            $request->document->move(
                $documentPath,
                $documentName
            );

            $data['document'] = $documentName;
        }

        $lecture->update($data);

        return redirect()
            ->route('admin.lectures.index')
            ->with('success', 'Lecture updated successfully!');
    }


    // Delete Lecture using ID
    public function destroy($id)
    {
        $lecture = Lecture::findOrFail($id);

        // Delete Video
        if ($lecture->video) {

            $videoPath = public_path(
                'uploads/lectures/videos/' . $lecture->video
            );

            if (File::exists($videoPath)) {
                File::delete($videoPath);
            }
        }

        // Delete Document
        if ($lecture->document) {

            $documentPath = public_path(
                'uploads/lectures/documents/' . $lecture->document
            );

            if (File::exists($documentPath)) {
                File::delete($documentPath);
            }
        }

        $lecture->delete();

        return redirect()
            ->route('admin.lectures.index')
            ->with('success', 'Lecture deleted successfully!');
    }
}
