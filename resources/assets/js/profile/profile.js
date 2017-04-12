import Vue from 'vue';
import axios from 'axios';
import Echo from 'laravel-echo';
import Notify from 'izitoast';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

new Vue({
    el: "#main",
    mounted(){
        window.Echo.channel(`author.${window.authorId}`)
            .listen('.AdWasSubmitted', e => {
                console.log(e);
                window.location.reload(true);
            });
    }
});