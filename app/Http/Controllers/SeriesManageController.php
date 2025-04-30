<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesManageController extends Controller
{
    public function index()
    {
        $series = Series::all(); // Fetch all series
        return view('series.manage.index', compact('series')); // Pass $series to the view
    }

    public function create()
    {
        return view('series.manage.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create series')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $series = new Series();
        $series->title = $request->input('title');
        $series->description = $request->input('description');
        $series->user_name = auth()->user()->name;
        $series->user_id = auth()->id();
        $series->published_at = now();
        $series->save();

        return redirect()->route('series.manage.index')->with('success', 'Series created successfully.');
    }

    public function show($id)
    {
        $serie = Series::findOrFail($id); // Fetch the series by ID
        return view('series.manage.show', compact('serie')); // Pass $serie to the view
    }
    public function edit($id)
    {
        $serie = Series::findOrFail($id); // Fetch the specific series by ID
        $series = Series::all(); // Fetch all series for the table
        return view('series.manage.edit', compact('serie', 'series')); // Pass both variables to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $serie = Series::findOrFail($id);
        $serie->update($request->only(['title', 'description']));

        return redirect()->route('series.manage.index')->with('success', 'Series updated successfully.');
    }

    public function destroy($id)
    {
        $serie = Series::findOrFail($id);
        $serie->delete();

        return redirect()->route('series.manage.index')->with('success', 'Series deleted successfully.');
    }
    public function delete($id)
    {
        $serie = Series::findOrFail($id); // Correct variable name
        return view('series.manage.delete', compact('serie'));

    }
}