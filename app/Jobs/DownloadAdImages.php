<?php

namespace App\Jobs;

use App\Events\ImagesDownloaded;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DownloadAdImages implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $ad;
    /**
     * @var
     */
    private $image_size;
    /**
     * @var
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param $user
     * @param $ad
     * @param $image_size
     */
    public function __construct($user, $ad, $image_size)
    {
        $this->ad = $ad;
        $this->image_size = $image_size;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $image_names = $this->getAdImagesRemotePaths();
            foreach ($image_names as $name){
                $path = "/ads/{$name}";
                $content = Storage::cloud()->get($path);
                $this->saveImagesLocally($content, $name);
            }
            event(new ImagesDownloaded($this->user, $this->ad));
        } catch (\Exception $e){
            var_dump($e);
        }
    }

    /**
     * @return array
     */
    private function getAdImagesRemotePaths()
    {
        return collect($this->ad['images'])->filter(function($img){
            return $img['size'] == $this->image_size;
        })->map(function($img){
            return "{$img['name']}";
        })->toArray();
    }

    /**
     * @param $content
     * @param $name
     */
    private function saveImagesLocally($content, $name)
    {
        Storage::disk('public')
            ->put("ads/{$name}", $content);
    }
}
