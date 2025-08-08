import Echo from '@ably/laravel-echo';
import * as Ably from 'ably';

window.Ably = Ably;
window.Echo = new Echo({
    broadcaster: 'ably',
});

window.Echo.connector.ably.connection.on(stateChange => {
    if (stateChange.current === 'connected') {
        console.log("LOGGER:: Connection event :: ", stateChange);
        if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
            console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
        }
    }
    if (stateChange.current === 'disconnected' || stateChange.current === 'suspended' || stateChange.current === 'failed') {
        window.onfocus = function () {
            window.Echo.connect();
        }
    }
});
