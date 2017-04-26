import Vue from 'vue';
// import axios from 'axios';
// import Notify from 'izitoast';

const host = window.location.host;
const socket = io.connect('http://' + host + ':8443');

new Vue({
    el: "#main",
    mounted(){
        // const channel = `Author.${window.authorId}`;
        // socket.on(`${channel}:AdWasSubmitted`, () => {
        //     window.location.reload(true);
        // });
    }
});