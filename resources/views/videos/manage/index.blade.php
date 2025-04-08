@extends('layouts.videos-app-layout')

@section('content')
    <h1>Manage Videos</h1>
    <div class="video-grid">
        @foreach($videos as $video)
            @php
                // Extract the video ID from the YouTube URL
                preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video['url'], $matches);
                $videoId = $matches[1] ?? null;
                // Construct the thumbnail URL
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'default-thumbnail.jpg';
            @endphp
            <div class="video-item">
                <a href="{{ route('videos.manage.show', ['video' => $video['id']]) }}" class="thumbnail-link">
                    <div class="thumbnail-container">
                        <img src="{{ $thumbnailUrl }}" alt="{{ $video['title'] }}">
                    </div>
                </a>
                <div class="video-details">
                    <a href="{{ route('videos.manage.show', ['video' => $video['id']]) }}">
                        <h3>{{ Str::limit($video['title'], 60) }}</h3>
                    </a>
                    <p class="video-meta">
                        {{ $video['description'] ? Str::limit($video['description'], 100) : 'No description' }}
                    </p>
                    <div class="manage-buttons">
                        <a href="{{ route('videos.manage.edit', ['video' => $video['id']]) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('videos.manage.destroy', ['video' => $video['id']]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this video?')">Delete</button>
                        </form>
                        <a href="{{ route('videos.manage.show', ['video' => $video['id']]) }}" class="btn btn-show">Show</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('styles')
    <style>
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
            background-color: #f5f7fa;
        }
        .video-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }
        .video-item:hover {
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.15);
        }
        .thumbnail-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 Aspect Ratio */
        }
        .thumbnail-link img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-bottom: 1px solid #e8ecef;
        }
        .video-details {
            padding: 12px;
        }
        .video-item h3 {
            font-size: 16px;
            font-weight: 500;
            color: #0052cc;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }
        .video-item h3:hover {
            color: #003d99;
        }
        .video-meta {
            font-size: 13px;
            color: #4a5568;
            margin: 0 0 4px 0;
            line-height: 1.4;
        }
        .manage-buttons {
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            margin-right: 5px;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-show {
            background-color: #007bff;
        }
    </style>
@endsection