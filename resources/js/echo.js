
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    logToConsole: true,
    csrfToken:$('meta[name="csrf-token"]').attr('content')
});

// import Echo from 'laravel-echo';
//
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     encrypted: true,
//     logToConsole: true,
//     auth: { headers: { "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content') }},
//     authEndpoint: "https://tukon.asia-one.co.id/broadcasting/auth"
// });
