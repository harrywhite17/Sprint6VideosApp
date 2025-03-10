<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Helpers\VideoHelper;
use Tests\Feature\Video\VideoTest;

class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('videos.index', compact('videos'));
    }

    public function show($id = null)
    {
        if (!$id) {
            $videoData = VideoHelper::create_default_video();
        } else {
            $videoData = Video::findOrFail($id);
        }

        return view('videos.show', ['video' => $videoData]);
    }

    public function testedby()
    {
        return VideoTest::class;
    }
}