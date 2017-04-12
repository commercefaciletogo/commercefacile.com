<?php

namespace App\Jobs;

use App\Ad;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessRejectedAds implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
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

        if($diff >= 7){
            $this->delete_ad();
        }
    }

    private function delete_ad()
    {
        $paths = $this->ad->images->map(function($img){
            return $this->formatPath($img['path']);
        });

        $this->deleteAdImages($paths, 'rackspace');
        $this->ad->images()->delete();
        $this->ad->delete();
    }

    private function deleteAdImages($paths, $disk)
    {
        dispatch(new DeleteAdImages($paths, $disk));
    }

    private function formatPath($path)
    {
        $name = collect(explode("/", $path))
            ->last();

        return "/ads/{$name}";
    }
}
