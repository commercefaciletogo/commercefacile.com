const app = require('http').createServer(handler);

const _ = require('lodash');

const io = require('socket.io')(app);

const Redis = require('ioredis');

const redis = new Redis(6379, 'redis');

function handler(req, res){
    res.writeHead(200);
    res.end('');
}

redis.on('pmessage', function(pattern, channel, message){
    channelHandler(channel, message);
});

function channelHandler(channel, message){
    console.log("*********Server Broadcast************");
    var msg = JSON.parse(message);
    var channel_event = channel+":"+msg.event;
    console.log(channel_event, JSON.stringify(msg.data));
    io.emit(channel_event, JSON.stringify(msg.data));
    io.emit("testing", msg.event);
    console.log("**************************************");
}

app.listen(3000, function(){
    console.log('socket server started');
});