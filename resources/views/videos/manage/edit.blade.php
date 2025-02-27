{{-- resources/views/videos/manage/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    @can('edit videos')
        <h1>Edit Video</h1>
        <form action="{{ route('videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $video->title }}" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required>{{ $video->description }}</textarea>
            <button type="submit">Update</button>
        </form>

        <h2>Manage Videos</h2>
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($videos as $video)
                <tr>
                    <td>{{ $video->title }}</td>
                    <td>{{ $video->description }}</td>
                    <td>
                        <a href="{{ route('videos.edit', $video->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection