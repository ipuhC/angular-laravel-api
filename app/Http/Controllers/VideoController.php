<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    
    public function updateLikes($id, Request $request)
    {
        $video = Video::findOrFail($id);
        $video->likes = $request->input('likes');
        $video->save();

        return response()->json($video, 200);
    }

    public function updateDislikes($id, Request $request)
    {
        $video = Video::findOrFail($id);
        $video->dislikes = $request->input('dislikes');
        $video->save();

        return response()->json($video, 200);
    }

    public function updateViews($id, Request $request)
    {
        $video = Video::findOrFail($id);
        $video->views = $request->input('views');
        $video->save();

        return response()->json($video, 200);
    }

    public function getComments($id)
    {
        $video = Video::with('comments.user')->find($id);

        if (!$video) {
            return response()->json([
                'success' => false,
                'message' => 'Video not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'comments' => $video->comments,
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return response()->json($videos);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'video_name' => 'required|string|max:255',
            'likes' => 'required|integer|min:0|max:9999999999',
            'dislikes' => 'required|integer|min:0|max:9999999999',
            'views' => 'required|integer|min:0|max:9999999999',
            'upload_date' => 'required|date',
            'username' => 'required|string|max:255',
            'video_file' => 'required|file|mimes:mp4,wav|max:20480', // 20MB Max
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:20480', // 20MB Max
        ]);

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $validatedData['video_file'] = $videoPath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        $video = Video::create($validatedData);

        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validatedData = $request->validate([
            'video_name' => 'required|string|max:255',
            'likes' => 'required|integer|min:0|max:9999999999',
            'dislikes' => 'required|integer|min:0|max:9999999999',
            'views' => 'required|integer|min:0|max:9999999999',
            'upload_date' => 'required|date',
            'username' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,wav|max:20480', // 20MB Max
            'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg|max:20480', // 20MB Max
        ]);

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete the old video file if it exists
            if ($video->video_file) {
                Storage::disk('public')->delete($video->video_file);
            }

            $videoPath = $request->file('video_file')->store('videos', 'public');
            $validatedData['video_file'] = $videoPath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $validatedData['thumbnail'] = $thumbnailPath;
        }

        $video->update($validatedData);

        return response()->json($video);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        // Delete the video file
        if ($video->video_file) {
            Storage::disk('public')->delete($video->video_file);
        }

        // Delete the thumbnail
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();
        return response()->json(null, 204);
    }
}
