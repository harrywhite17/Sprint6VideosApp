@extends('layouts.videos-app-layout')

@section('content')
    <h1>Manage Users</h1>
    <form action="{{ route('users.manage.index') }}" method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="form-control" data-qa="input-search">
        <button type="submit" class="btn btn-primary" data-qa="button-search">Search</button>
    </form>
    <div class="main-container">
        <div class="user-grid">
            @foreach($users as $user)
                <div class="user-container">
                    <div class="user-item">
                        <div class="user-details">
                            <h3><a href="{{ route('users.manage.show', $user->id) }}">{{ Str::limit($user->name, 60) }}</a></h3>
                            <p class="user-meta">{{ $user->email }}</p>
                            <div class="manage-buttons">
                                <a href="{{ route('users.manage.edit', $user->id) }}" class="btn btn-edit">Edit</a>
                                <a href="{{ route('users.manage.delete', $user->id) }}" class="btn btn-delete">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .search-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .main-container {
            padding: 20px;
            background-color: #efefef;
            border-radius: 8px;
        }
        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .user-container {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 8px;
        }
        .user-item {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }
        .user-item:hover {
            box-shadow: 0 4px 12px rgba(0, 82, 204, 0.15);
        }
        .user-details {
            padding: 12px;
        }
        .user-item h3 {
            font-size: 16px;
            font-weight: 500;
            color: #0052cc;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }
        .user-item h3 a {
            text-decoration: none;
            color: inherit;
        }
        .user-item h3 a:hover {
            color: #003d99;
        }
        .user-meta {
            font-size: 13px;
            color: #4a5568;
            margin: 0 0 4px 0;
            line-height: 1.4;
        }
        .manage-buttons {
            margin-top: 10px;
        }
        .btn {
            background-color: #6c757d;
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