@extends('layouts.videos-app-layout')

@section('content')
    <div class="container">
        <div class="video-wrapper">
            <h1>{{ $video['title'] }}</h1>
            <div class="video-player">
                <iframe src="{{ $video['url'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <p class="video-meta"><strong>Description:</strong> {{ $video['description'] ?? 'No description available' }}</p>
            <p class="video-meta"><strong>Published At:</strong> {{ $video['published_at'] }}</p>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .video-wrapper {
            text-align: center; /* Centers text and inline elements */
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px; /* Slightly wider for a bigger video */
        }

        h1 {
            font-size: 32px; /* Larger title */
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 25px;
            line-height: 1.2;
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

        .video-player {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            margin: 25px 0;
            background: #000;
            max-width: 900px; /* Larger video width */
            margin-left: auto; /* Centers the video */
            margin-right: auto;
        }

        .video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 12px;
        }
    </style>
@endsection