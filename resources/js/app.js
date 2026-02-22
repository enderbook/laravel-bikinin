require('./bootstrap');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Menerima pesan
Echo.private(`chat.${chatId}`) // Ganti chatId dengan ID chat yang sesuai
    .listen('MessageSent', (e) => {
        // Tambahkan kode untuk menampilkan pesan baru di chat
        console.log(e.pesan);
        // Misalnya, menambahkan pesan baru ke tampilan chat
    });
