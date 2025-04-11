@extends('layouts.videos-app-layout')

@section('content')
    @can('edit series')
        <div class="container">
            <h1>Edit Series</h1>
            <form action="{{ route('series.update', $serie->id) }}" method="POST" data-qa="form-edit-series" class="create-series-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title" data-qa="label-title">Title:</label>
                    <input type="text" id="title" name="title" value="{{ $serie->title }}" required data-qa="input-title" class="form-control">
                </div>

                <div class="form-group">
                    <label for="description" data-qa="label-description">Description:</label>
                    <textarea id="description" name="description" required data-qa="textarea-description" class="form-control">{{ $serie->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="user_name" data-qa="label-user_name">User Name:</label>
                    <input type="text" id="user_name" name="user_name" value="{{ $serie->user_name }}" required data-qa="input-user_name" class="form-control">
                </div>

                <button type="submit" data-qa="button-submit" class="btn btn-primary">Update</button>
            </form>

            <!-- Manage Videos in Series -->
            <div class="manage-videos">
                <h2>Videos in this Series</h2>
                @if($serie->videos->isEmpty())
                    <p>No videos in this series yet.</p>
                @else
                    <ul class="video-list">
                        @foreach($serie->videos as $video)
                            <li>
                                <span>{{ $video->title }}</span>
                                <form action="{{ route('series.removeVideo', [$serie->id, $video->id]) }}" method="POST" class="remove-form" onsubmit="return confirm('Are you sure you want to remove this video from the series?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Remove</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h2>Add Video to Series</h2>
                <form action="{{ route('series.addVideoFromEdit', $serie->id) }}" method="POST" class="add-video-form">
                    @csrf
                    <div class="form-group">
                        <label for="video_id">Select Video:</label>
                        <select name="video_id" id="video_id" required class="form-control">
                            <option value="">-- Select a Video --</option>
                            @foreach($videos->whereNotIn('id', $serie->videos->pluck('id')->toArray()) as $video)
                                <option value="{{ $video->id }}">{{ $video->title }}</option>
                            @endforeach
                        </select>
                        @error('video_id')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Video</button>
                </form>
            </div>

            <h2>Manage Series</h2>
            <a href="{{ route('series.create') }}" class="btn btn-primary">Create New Series</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>User Name</th>
                    <th>Published At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($series as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ Str::limit($item->description, 100) }}</td>
                        <td>{{ $item->user_name }}</td>
                        <td>{{ $item->published_at }}</td>
                        <td>
                            <a href="{{ route('series.show', $item->id) }}" class="btn btn-show">Show</a>
                            <a href="{{ route('series.edit', $item->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('series.manage.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this series?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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

        .create-series-form {
            max-width: 600px;
            margin: 0 auto 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #222;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
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

        .manage-videos {
            max-width: 600px;
            margin: 0 auto 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .manage-videos h2 {
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center;
        }

        .video-list {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .video-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .video-list li span {
            font-size: 16px;
            color: #4a5568;
        }

        .remove-form {
            margin: 0;
        }

        .add-video-form {
            margin-top: 20px;
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

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f5f7fa;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .error {
            color: red;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
    </style>
@endsection