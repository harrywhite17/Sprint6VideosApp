@extends('layouts.videos-app-layout')

@section('content')
    @can('view series')
        <h1>Manage Series</h1>
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
            @foreach($series as $serie)
                <tr>
                    <td>{{ $serie->title }}</td>
                    <td>{{ Str::limit($serie->description, 100) }}</td>
                    <td>{{ $serie->user_name }}</td>
                    <td>{{ $serie->published_at }}</td>
                    <td>
                        <a href="{{ route('series.show', $serie->id) }}" class="btn btn-show">Show</a>
                        <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-edit">Edit</a>
                        <a href="{{ route('series.delete', $serie->id) }}" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection

@section('styles')
    <style>
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
    </style>
@endsection