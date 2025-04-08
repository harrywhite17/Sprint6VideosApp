@extends('layouts.videos-app-layout')

@section('content')
    @can('view series')
        <h1>All Series</h1>
        <form action="{{ route('series.index') }}" method="GET" data-qa="form-search-series" class="search-series-form">
            <div class="form-group">
                <input type="text" name="search" placeholder="Search series..." data-qa="input-search" class="form-control" value="{{ request('search') }}">
                <button type="submit" data-qa="button-search" class="btn btn-primary">Search</button>
            </div>
        </form>
        <div class="series-list">
            @foreach($series as $serie)
                <div class="series-item">
                    <a href="{{ route('series.show', $serie->id) }}" class="series-link">
                        <h2>{{ $serie->title }}</h2>
                        <p>{{ Str::limit($serie->description, 100) }}</p>
                    </a>
                </div>
            @endforeach
        </div>
        {{ $series->links() }}
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
        .search-series-form {
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            gap: 10px;
        }
        .form-control {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        .series-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .series-item {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s ease;
        }
        .series-item:hover {
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.15);
        }
        .series-link {
            text-decoration: none;
            color: inherit;
        }
        .series-link h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .series-link p {
            font-size: 16px;
            color: #4a5568;
        }
    </style>
@endsection