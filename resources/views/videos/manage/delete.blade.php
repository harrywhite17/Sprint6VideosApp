{{-- resources/views/videos/manage/delete.blade.php --}}
@extends('layouts.app')

@section('content')
    @can('delete videos')
        <h1>Delete Video</h1>
        <p>Are you sure you want to delete this video?</p>
        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection