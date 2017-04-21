<?php

namespace App\Events;

use App\Ad;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ImagesDownloaded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var
     */
    private $user;
    /**
     * @var Ad
     */
    private $ad;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param Ad $ad
     */
    public function __construct($user, Ad $ad)
    {
        $this->user = $user;
        $this->ad = $ad;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return 'Ad.'.$this->ad->id;
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return "ImagesDownloaded";
    }
}
