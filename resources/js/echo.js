import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: 'realtime-pusher.ably.io', //import.meta.env.VITE_REVERB_HOST,
    wsPort: 443, //import.meta.env.VITE_REVERB_PORT ?? 80,
    disableStats: true,
    encrypted: true,
    //wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    //forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    //enabledTransports: ["ws", "wss"],
    //cluster: "Redis",
});
