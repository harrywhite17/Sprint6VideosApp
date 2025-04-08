<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::paginate(10); // Adjust the number of items per page as needed
        return view('series.index', compact('series'));
    }

    public function show($id)
    {
        $serie = Series::findOrFail($id);
        return view('series.show', compact('serie'));
    }
}