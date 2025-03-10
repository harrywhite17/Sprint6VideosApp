@extends('layouts.videos-app-layout')

@section('content')
    <div class="container">
        <h1>User Details</h1>
        <div class="user-details">
            <h2>{{ $user->name }}</h2>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <h3>Videos</h3>
            @if($user->videos->isEmpty())
                <p>No videos available.</p>
            @else
                <div class="video-grid">
                    @foreach($user->videos as $video)
                        <div class="video-item">
                            <h4><a href="{{ route('videos.show', $video->id) }}">{{ $video->title }}</a></h4>
                            <p>{{ $video->description }}</p>
                            @php
                                // Extract the video ID from the YouTube URL
                                preg_match('/embed\/([a-zA-Z0-9_-]+)/', $video->url, $matches);
                                $videoId = $matches[1] ?? null;
                                // Construct the thumbnail URL
                                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'default-thumbnail.jpg';
                            @endphp
                            <img src="{{ $thumbnailUrl }}" alt="Video Thumbnail" class="video-thumbnail">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.15);
        }
        .user-details {
            padding: 12px;
        }
        .user-details h2 {
            font-size: 24px;
            font-weight: 500;
            color: #0052cc;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }
        .user-details p {
            font-size: 16px;
            color: #4a5568;
            margin: 0 0 4px 0;
            line-height: 1.4;
        }
        .user-details h3 {
            font-size: 20px;
            font-weight: 500;
            color: #0052cc;
            margin: 20px 0 8px 0;
            line-height: 1.3;
        }
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .video-item {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .video-item h4 {
            font-size: 18px;
            font-weight: 500;
            color: #0052cc;
            margin: 0 0 8px 0;
        }
        .video-item h4 a {
            text-decoration: none;
            color: inherit;
        }
        .video-item h4 a:hover {
            color: #003d99;
        }
        .video-item p {
            font-size: 14px;
            color: #4a5568;
            margin: 0 0 8px 0;
        }
        .video-thumbnail {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
@endsection