@extends('layouts.videos-app-layout')

@section('content')
    @can('delete series')
        <h1>Delete Series</h1>
        <p>Are you sure you want to delete the series "{{ $serie->title }}"?</p>
        <div class="video-details">
            <h2>{{ $serie->title }}</h2>
            <p>{{ $serie->description }}</p>
            <img src="{{ $serie->image ?? 'default-thumbnail.jpg' }}" alt="Series Thumbnail" class="video-thumbnail">
            <p class="video-meta"><strong>Published At:</strong> {{ $serie->published_at }}</p>
        </div>
        <form action="{{ route('series.destroy', $serie->id) }}" method="POST" data-qa="form-delete-series" class="create-series-form">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label for="delete_videos" data-qa="label-delete-videos">
                    <input type="checkbox" id="delete_videos" name="delete_videos" data-qa="input-delete-videos">
                    Delete associated videos
                </label>
            </div>
            <button type="submit" data-qa="button-submit" class="btn btn-primary">Delete</button>
        </form>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
        .create-series-form {
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