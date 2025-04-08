<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            text-align: center;
        }
        nav {
            background-color: #444;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
        }
        nav a {
            margin: 0 15px;
            color: #fff;
            text-decoration: underline;
            cursor: pointer;
        }
        main {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .video-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    @yield('styles')
</head>
<body>
<div id="app">
    <!-- Header Section -->
    <header>
        <h1>{{ config('app.name', 'Laravel') }}</h1>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <a href="{{ route('videos.index') }}">Home</a>
        <a href="{{ route('videos.manage.index') }}">Manage Videos</a>
        <a href="{{ route('videos.manage.create') }}">Create Video</a>
        <a href="{{ route('users.manage.index') }}">Manage Users</a>
        <a href="{{ route('users.manage.create') }}">Create User</a>
        <a href="{{ route('series.index') }}">All Series</a>
        <a href="{{ route('series.manage.index') }}">Manage Series</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="video-container" style="padding-bottom: 150px;">
            @yield('content')
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </footer>
</div>
</body>
</html>