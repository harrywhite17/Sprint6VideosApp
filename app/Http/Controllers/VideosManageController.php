<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosManageController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('videos.manage.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.manage.create');
    }

    public function store(Request $request)
    {
        Video::create($request->all());
        return redirect()->route('videos.manage.index')->with('success', 'Video created successfully.');
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.show', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->update($request->all());
        return redirect()->route('videos.manage.index')->with('success', 'Video updated successfully.');
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.delete', compact('video'));
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->route('videos.manage.index')->with('success', 'Video deleted successfully.');
    }
}