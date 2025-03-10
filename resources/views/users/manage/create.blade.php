@extends('layouts.videos-app-layout')

@section('content')
    <div class="container">
        <h1>Create User</h1>
        <form action="{{ route('users.manage.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" data-qa="input-name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" data-qa="input-email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" data-qa="input-password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" data-qa="input-password-confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary" data-qa="button-submit">Create</button>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control {
            width: 100%;
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
    </style>
@endsection