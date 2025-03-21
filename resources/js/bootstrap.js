/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
// import Echo from "laravel-echo";
// import * as Ably from "ably";

window.axios = axios;
// window.Ably = Ably;
// window.Echo = new Echo({
//     broadcaster: 'ably',
//     authEndpoint: '/broadcasting/auth'
// });

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/* Ably */
// window.Echo.connector.ably.connection.on((stateChange) => {
//     console.log("LOGGER:: Connection event :: ", stateChange);
//     if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
//         console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
//     }
// });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

/*import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    // cluster: import.meta.env.VITE_REVERB_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_REVERB_HOST ? import.meta.env.VITE_REVERB_HOST : `ws-${import.meta.env.VITE_REVERB_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});*/

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

// import "./echo";
