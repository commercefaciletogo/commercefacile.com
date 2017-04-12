<?php

namespace App\Jobs;

use App\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessAds implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Ad::all()->each(function($ad){
            $ad_status = $ad->status;
            switch ($ad_status){
                case 'online':
                    dispatch(new ProcessOnlineAds($ad));
                    break;
                case 'offline':
                    dispatch(new ProcessOfflineAds($ad));
                    break;
                case 'rejected':
                    dispatch(new ProcessRejectedAds($ad));
                    break;
            }
        });
    }
}
