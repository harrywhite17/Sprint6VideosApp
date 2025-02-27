@extends('layouts.videos-app-layout')

@section('content')
    @can('delete videos')
        <h1>Delete Video</h1>
        <p>Are you sure you want to delete this video?</p>
        <div class="video-details">
            <h2>{{ $video->title }}</h2>
            <p>{{ $video->description }}</p>
            @php
                // Extract the video ID from the YouTube URL
                preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video->url, $matches);
                $videoId = $matches[1] ?? null;
                // Construct the thumbnail URL
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'default-thumbnail.jpg';
            @endphp
            <img src="{{ $thumbnailUrl }}" alt="Video Thumbnail" class="video-thumbnail">
            <p class="video-meta"><strong>Published At:</strong> {{ $video->published_at }}</p>
        </div>
        <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" data-qa="form-delete-video" class="create-video-form">
            @csrf
            @method('DELETE')
            <button type="submit" data-qa="button-submit" class="btn btn-primary">Delete</button>
        </form>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
        .create-video-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .video-details {
            margin-bottom: 20px;
        }
        .video-details h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .video-details p {
            font-size: 16px;
            color: #4a5568;
        }
        .video-thumbnail {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .video-meta {
            font-size: 16px;
            color: #666;
            margin: 15px 0;
            line-height: 1.5;
        }
        .video-meta strong {
            color: #222;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endsection