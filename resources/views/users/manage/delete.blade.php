@extends('layouts.videos-app-layout')

@section('content')
    <div class="container">
        <h1>Delete User</h1>
        <form action="{{ route('users.manage.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <p>Are you sure you want to delete user {{ $user->name }}?</p>
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('users.manage.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
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
        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
@endsection