<?php

namespace App\Jobs;

use App\Ad;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessOnlineAds implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    const DURATION_IN_DAYS = 14;

    /**
     * @var Ad
     */
    private $ad;

    /**
     * Create a new job instance.
     *
     * @param Ad $ad
     */
    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $start_date = Carbon::parse($this->ad->start_date);
        $end_date = Carbon::parse($this->ad->end_date);
        $diff = $start_date->diffInDays($end_date);
        if($diff >= 14){
            $this->put_ad_off();
        }
    }

    private function put_ad_off()
    {
        $this->ad->update(['status' => 'offline']);
    }
}
