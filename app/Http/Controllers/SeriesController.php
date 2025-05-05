<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::paginate(10);
        return view('series.index', compact('series'));
    }

    public function show($id)
    {
        $serie = Series::with('videos')->findOrFail($id);
        $videos = \App\Models\Video::all();
        return view('series.show', compact('serie', 'videos'));
    }

    public function edit($id)
    {
        $serie = Series::with('videos')->findOrFail($id);
        $series = Series::all(); // For the table
        $videos = \App\Models\Video::whereNotIn('id', $serie->videos->pluck('id')->toArray())->get();
        return view('series.manage.edit', compact('serie', 'series', 'videos')); // Adjust path if needed
    }

    public function update(Request $request, Series $series)
    {
        if ($series->user_id !== auth()->id() && !auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_name' => 'required|string|max:255',
        ]);

        $series->update($request->only(['title', 'description', 'user_name']));

        return redirect()->route('series.edit', $series)->with('success', 'Series updated successfully.');
    }

    public function addVideo(Request $request, Series $series)
    {

        if (!auth()->user()->hasRole('super-admin') && !auth()->user()->can('add videos to series')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $video = \App\Models\Video::findOrFail($request->video_id);
        if (!$series->videos()->where('videos.id', $video->id)->exists()) {
            $series->videos()->attach($video);
            $message = 'Video added to series successfully.';
        } else {
            $message = 'Video is already in this series.';
        }

        return redirect()->route('series.show', $series)->with('success', $message);
    }

    public function addVideoFromEdit(Request $request, Series $series)
    {

        if (!auth()->user()->hasRole('super-admin') && $series->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $video = \App\Models\Video::findOrFail($request->video_id);
        if (!$series->videos()->where('videos.id', $video->id)->exists()) {
            $series->videos()->attach($video);
            $message = 'Video added to series successfully.';
        } else {
            $message = 'Video is already in this series.';
        }

        return redirect()->route('series.edit', $series)->with('success', $message);
    }

    public function removeVideo(Request $request, Series $series, $videoId)
    {
        if ($series->user_id !== auth()->id() && !auth()->user()->hasRole('super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $video = \App\Models\Video::findOrFail($videoId);
        if ($series->videos()->where('videos.id', $video->id)->exists()) {
            $series->videos()->detach($video);
            $message = 'Video removed from series successfully.';
        } else {
            $message = 'Video is not in this series.';
        }

        return redirect()->route('series.edit', $series)->with('success', $message);
    }
}