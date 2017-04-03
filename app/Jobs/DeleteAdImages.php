<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DeleteAdImages implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $paths;
    /**
     * @var
     */
    private $disk;

    /**
     * Create a new job instance.
     *
     * @param $paths
     * @param $disk
     */
    public function __construct($paths, $disk)
    {
        $this->paths = $paths;
        $this->disk = $disk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->paths)
            ->map(function($path){
                return $this->formatPath($path);
            })
            ->each(function($path){
            Storage::disk($this->disk)
                ->delete($path);
        });
    }

    private function formatPath($path)
    {
        $name = collect(explode("/", $path))
            ->last();

        return "/ads/{$name}";
    }
}
