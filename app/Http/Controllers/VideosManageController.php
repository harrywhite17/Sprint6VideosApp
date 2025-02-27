<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosManageController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view ('videos.manage.index', compact('videos'));
    }
    public function create ()
    {
        return view('videos.manage.create');
    }
    public function store(Request $request)
    {
        $video = Video::create($request->all());
        return response()->json($video, 201);
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('videos.manage.show', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->update($request->all());
        return response()->json($video);
    }

    public function delete($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return response()->json(null, 204);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return response()->json(null, 204);
    }

    public function testedby()
    {

        return response()->json(['message' => 'Tested by function']);
    }
}