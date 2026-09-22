<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LectureApiController extends Controller
{
    // Get All Lectures
    public function index()
    {
        try {

            $lectures = Lecture::with('course')
                ->orderBy('course_id')
                ->orderBy('lecture_order')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Lectures fetched successfully',
                'data' => $lectures
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Get Single Lecture
    public function show($id)
    {
        try {

            $lecture = Lecture::with('course')->find($id);

            if (!$lecture) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Lecture fetched successfully',
                'data' => $lecture
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Store Lecture
    public function store(Request $request)
    {
        try {

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

            $videoName = null;
            $documentName = null;

            // Upload Video
            if ($request->hasFile('video')) {

                $videoPath = public_path(
                    'uploads/lectures/videos'
                );

                if (!File::exists($videoPath)) {
                    File::makeDirectory(
                        $videoPath,
                        0755,
                        true
                    );
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

                $documentPath = public_path(
                    'uploads/lectures/documents'
                );

                if (!File::exists($documentPath)) {
                    File::makeDirectory(
                        $documentPath,
                        0755,
                        true
                    );
                }

                $documentName = time() . '_' .
                    $request->document->getClientOriginalName();

                $request->document->move(
                    $documentPath,
                    $documentName
                );
            }

            $lecture = Lecture::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'description' => $request->description,
                'video_url' => $request->video_url,
                'video' => $videoName,
                'document' => $documentName,
                'lecture_order' => $request->lecture_order,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Lecture added successfully',
                'data' => $lecture
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Update Lecture
    public function update(Request $request, $id)
    {
        try {

            $lecture = Lecture::find($id);

            if (!$lecture) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

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

                $videoPath = public_path(
                    'uploads/lectures/videos'
                );

                if (!File::exists($videoPath)) {
                    File::makeDirectory(
                        $videoPath,
                        0755,
                        true
                    );
                }

                // Delete old video
                if (
                    $lecture->video &&
                    File::exists(
                        $videoPath . '/' . $lecture->video
                    )
                ) {
                    File::delete(
                        $videoPath . '/' . $lecture->video
                    );
                }

                $videoName = time() . '_' .
                    $request->video->getClientOriginalName();

                $request->video->move(
                    $videoPath,
                    $videoName
                );

                $data['video'] = $videoName;
            }

            // Upload New Document
            if ($request->hasFile('document')) {

                $documentPath = public_path(
                    'uploads/lectures/documents'
                );

                if (!File::exists($documentPath)) {
                    File::makeDirectory(
                        $documentPath,
                        0755,
                        true
                    );
                }

                // Delete old document
                if (
                    $lecture->document &&
                    File::exists(
                        $documentPath . '/' . $lecture->document
                    )
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

            return response()->json([
                'status' => true,
                'message' => 'Lecture updated successfully',
                'data' => $lecture
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Delete Lecture
    public function destroy($id)
    {
        try {

            $lecture = Lecture::find($id);

            if (!$lecture) {
                return response()->json([
                    'status' => false,
                    'message' => 'Lecture not found'
                ], 404);
            }

            // Delete Video
            if ($lecture->video) {

                $videoPath = public_path(
                    'uploads/lectures/videos/' .
                    $lecture->video
                );

                if (File::exists($videoPath)) {
                    File::delete($videoPath);
                }
            }

            // Delete Document
            if ($lecture->document) {

                $documentPath = public_path(
                    'uploads/lectures/documents/' .
                    $lecture->document
                );

                if (File::exists($documentPath)) {
                    File::delete($documentPath);
                }
            }

            $lecture->delete();

            return response()->json([
                'status' => true,
                'message' => 'Lecture deleted successfully'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Get Lectures By Course
    public function byCourse($courseId)
    {
        try {

            $lectures = Lecture::with('course')
                ->where('course_id', $courseId)
                ->orderBy('lecture_order')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Course lectures fetched successfully',
                'data' => $lectures
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