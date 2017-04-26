<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProcessingAdImages implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $broadcastQueue = 'broadcast';

    private $user;
    /**
     * @var
     */
    private $stage;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $stage
     */
    public function __construct($user, $stage)
    {
        $this->user = $user;
        $this->stage = $stage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return "Author.{$this->user->uuid}";
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'ProcessingAdImages';
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return ['percent' => $this->stage, 'status' => $this->get_text()];
    }

    /**
     * @return string
     */
    private function get_text()
    {
        switch ($this->stage){
            case 10:
                return 'Loading...';
            case 30:
                return 'Processing...';
            case 50:
                return 'Uploading...';
            case 90:
                return 'Saving...';
            case 100:
                return 'Reloading...';
            default:
                return '';
        }
    }
}