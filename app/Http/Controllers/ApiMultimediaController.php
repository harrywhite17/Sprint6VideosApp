<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiMultimediaController extends Controller
{
    public function index()
    {
        $multimedia = Multimedia::all();
        return response()->json($multimedia);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:20480', // 20MB max
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('multimedia', $fileName, 'public');
        $fileType = $file->getClientMimeType();

        $multimedia = Multimedia::create([
            'user_id' => auth()->id(),
            'name' => $fileName,
            'path' => Storage::url($filePath),
            'type' => str_contains($fileType, 'video') ? 'video' : 'photo',
        ]);

        return response()->json($multimedia, 201);
    }

    public function show($id)
    {
        $multimedia = Multimedia::findOrFail($id);
        return response()->json($multimedia);
    }

    public function update(Request $request, $id)
    {
        // Optional: Add update logic if needed later
        return response()->json(['message' => 'Update not implemented'], 501);
    }

    public function destroy($id)
    {
        $multimedia = Multimedia::findOrFail($id);

        if ($multimedia->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete('multimedia/' . $multimedia->name);
        $multimedia->delete();

        return response()->json(null, 204);
    }

    public function userMultimedia()
    {
        $multimedia = auth()->user()->multimedia;
        return response()->json($multimedia);
    }
}