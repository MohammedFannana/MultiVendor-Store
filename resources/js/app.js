import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// from pusher server in laravelEcho frontend
// $userID is define in layouts/dashboard.blade.php
var channel = Echo.private(`App.Models.User.${userID}`);
channel.notifiaction(function(data) {
    alert(data.body);
    // alert(JSON.stringify(data));
});
