@extends('layouts.videos-app-layout')

@section('content')
    <div class="container">
        <div class="notifications-wrapper">
            <h1>Notifications</h1>
            <div id="notifications">
                <h2>Push Notifications</h2>
                <ul id="notification-list" class="notification-list">
                    @forelse ($notifications as $notification)
                        <li class="notification-item">
                            <div class="notification-content">
                                <strong>{{ $notification->data['user'] }}</strong>
                                <span>{{ $notification->data['action'] }}:</span>
                                <a href="{{ route('videos.show', $notification->data['video']['id']) }}" class="notification-video-title">{{ $notification->data['video']['title'] }}</a>
                            </div>
                            <span class="notification-timestamp">{{ $notification->created_at->format('d M Y H:i') }}</span>
                        </li>
                    @empty
                        <li class="notification-empty">No notifications available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .notifications-wrapper {
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

        h2 {
            font-size: 24px;
            font-weight: 500;
            color: #222;
            margin-bottom: 20px;
            text-align: center;
        }

        .notification-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            opacity: 0;
            animation: fadeIn 0.3s ease forwards;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .notification-content {
            flex-grow: 1;
            text-align: left;
        }

        .notification-content strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .notification-content span {
            color: #4a5568;
            font-size: 14px;
            margin: 0 5px;
        }

        .notification-video-title {
            font-size: 16px;
            color: #0056b3;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .notification-video-title:hover {
            color: #003087;
            text-decoration: underline;
        }

        .notification-timestamp {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
        }

        .notification-empty {
            text-align: center;
            color: #4a5568;
            font-size: 16px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        window.Echo.channel('videos')
            .listen('.video.created', (data) => {
                const notificationList = document.getElementById('notification-list');
                const newNotification = document.createElement('li');
                newNotification.className = 'notification-item';
                newNotification.innerHTML = `
                    <div class="notification-content">
                        <strong>${data.user}</strong>
                        <span>${data.action}:</span>
                        <a href="/videos/${data.video.id}" class="notification-video-title">${data.video.title}</a>
                    </div>
                    <span class="notification-timestamp">${new Date().toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
                `;
                notificationList.prepend(newNotification);
            });
    </script>
@endsection