@extends('layouts.videos-app-layout')

@section('content')
    @can('view series')
        <h1>{{ $serie->title }}</h1>
        <div class="video-details">
            <img src="{{ $serie->image ?? 'default-thumbnail.jpg' }}" alt="Series Thumbnail" class="video-thumbnail">
            <p>{{ $serie->description }}</p>
            <p class="video-meta"><strong>Published At:</strong> {{ $serie->published_at }}</p>
        </div>
        <div class="manage-buttons">
            <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-edit">Edit</a>
            <a href="{{ route('series.delete', $serie->id) }}" class="btn btn-delete">Delete</a>
        </div>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
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
    </style>
@endsection