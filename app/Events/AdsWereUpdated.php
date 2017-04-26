<?php

namespace App\Events;

use App\Ad;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdsWereUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $broadcastQueue = 'broadcast';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return 'Admin';
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'AdsWereUpdated';
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        $pendings = Ad::where('status', 'pending')->get();
        $rejecteds = Ad::where('status', 'rejected')->get();
        $onlines = Ad::where('status', 'online')->get();
        $offlines = Ad::where('status', 'offline')->get();

        return [
            'pending' => [
                'empty' => $pendings->isEmpty(),
                'count' => $pendings->count()
            ],
            'rejected' => [
                'empty' => $rejecteds->isEmpty(),
                'count' => $rejecteds->count()
            ],
            'online' => [
                'empty' => $onlines->isEmpty(),
                'count' => $onlines->count()
            ],
            'offline' => [
                'empty' => $offlines->isEmpty(),
                'count' => $offlines->count()
            ]
        ];
    }
}
