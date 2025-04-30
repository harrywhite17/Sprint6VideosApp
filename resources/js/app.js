import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

window.Echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        console.log(notification);
    });