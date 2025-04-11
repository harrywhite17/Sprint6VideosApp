@extends('layouts.videos-app-layout')

@section('content')
    @can('view series')
        <div class="container">
            <div class="series-wrapper">
                <h1>{{ $serie->title }}</h1>
                <p class="series-meta"><strong>Description:</strong> {{ $serie->description ?? 'No description available' }}</p>
                <p class="series-meta"><strong>Published At:</strong> {{ $serie->published_at ? $serie->published_at->format('d M Y') : 'Not published' }}</p>

                <!-- Videos in Series -->
                <div class="series-videos">
                    <h2>Videos in this Series</h2>
                    @if($serie->videos->isEmpty())
                        <p>No videos in this series yet.</p>
                    @else
                        <ul>
                            @foreach($serie->videos as $video)
                                <li>
                                    <a href="{{ route('videos.show', $video->id) }}">{{ $video->title }}</a>
                                    <p>{{ $video->description ?? 'No description' }}</p>
                                    <p class="series-meta">Published: {{ $video->published_at ? $video->published_at->format('d M Y') : 'Not published' }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Add Video Form -->
                <div class="add-video-form">
                    <h2>Add Video to Series</h2>
                    <form action="{{ route('series.addVideo', $serie) }}" method="POST">
                        @csrf
                        <div>
                            <label for="video_id">Select Video</label>
                            <select name="video_id" id="video_id" required>
                                <option value="">-- Select a Video --</option>
                                @foreach($videos->whereNotIn('id', $serie->videos->pluck('id')->toArray()) as $video)
                                    <option value="{{ $video->id }}">{{ $video->title }}</option>
                                @endforeach
                            </select>
                            @error('video_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit">Add Video</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .series-wrapper {
            text-align: center;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .series-meta {
            font-size: 16px;
            color: #666;
            margin: 15px 0;
            line-height: 1.5;
        }

        .series-meta strong {
            color: #222;
            font-weight: 500;
        }

        .series-videos {
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: left;
        }

        .series-videos h2 {
            font-size: 24px;
            margin-bottom: 15px;
            text-align: center;
        }

        .series-videos ul {
            list-style: none;
            padding: 0;
        }

        .series-videos li {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .series-videos li a {
            font-size: 18px;
            color: #007bff;
            text-decoration: none;
        }

        .series-videos li a:hover {
            text-decoration: underline;
        }

        .series-videos li p {
            font-size: 14px;
            color: #4a5568;
            margin: 5px 0;
        }

        .add-video-form {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-align: left;
        }

        .add-video-form h2 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
        }

        .add-video-form div {
            margin-bottom: 15px;
        }

        .add-video-form label {
            display: block            block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #222;
        }

        .add-video-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .add-video-form button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-video-form button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
    </style>
@endsection