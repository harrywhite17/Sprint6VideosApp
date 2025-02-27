@extends('layouts.videos-app-layout')

@section('content')
    <h1>{{ $video->title }}</h1>
    <div class="video-details">
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
        <div class="video-container">
            <iframe width="560" height="315" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .video-details {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        .video-container {
            margin-top: 20px;
        }
    </style>
@endsection