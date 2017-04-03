<?php

namespace App\Listeners;

use App\Events\AdsWereUpdated;
use App\Events\AdWasSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShouldUpdatePendingAds implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdWasSubmitted  $event
     * @return void
     */
    public function handle(AdWasSubmitted $event)
    {
        if($event->submitted){
            event(new AdsWereUpdated);
            var_dump($event->submitted);
        }
    }
}
