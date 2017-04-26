<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdWasSubmitted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $broadcastQueue = 'broadcast';

    private $author;
    public $submitted;

    /**
     * Create a new event instance.
     *
     * @param $author
     * @param $submitted
     */
    public function __construct($author, $submitted)
    {
        $this->author = $author;
        $this->submitted = $submitted;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return "Author.{$this->author->uuid}";
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'AdWasSubmitted';
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return ['submitted' => $this->submitted];
    }
}
