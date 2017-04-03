<?php

namespace App\Jobs;

use App\Ad;
use App\AdImage;
use App\Events\AdWasSubmitted;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessAdImages implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $number_of_images;
    /**
     * @var Ad
     */
    private $ad;
    /**
     * @var
     */
    private $images_paths;
    /**
     * @var
     */
    private $user;
    /**
     * @var bool
     */
    private $updating;

    /**
     * Create a new job instance.
     *
     * @param Ad $ad
     * @param $images_paths
     * @param $number_of_images
     * @param $user
     * @param bool $updating
     */
    public function __construct(Ad $ad, $images_paths, $number_of_images, $user, $updating = false)
    {
        $this->number_of_images = $number_of_images;
        $this->ad = $ad;
        $this->images_paths = $images_paths;
        $this->user = $user;
        $this->updating = $updating;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $this->saveAdImages();
            $paths = $this->moveImages();
            var_dump($paths);
            $this->cleanDisk();
            $this->savePaths($paths);
            event(new AdWasSubmitted($this->user, true));
        }catch (\Exception $e){
            event(new AdWasSubmitted($this->user, false));
            dd($e->getLine(), $e->getMessage());
        }
    }

    /**
     *
     */
    private function saveAdImages()
    {
        collect($this->images_paths)->each(function($path, $key){
            if(!Storage::disk('local')->exists($path)) return false;
            $index = $key + 1;
            $file = $this->getImage($path);

            $this->resizeAndSaveImage($file, 100, $this->ad, $index);
            $this->resizeAndSaveImage($file, null, $this->ad, $index);
            $this->resizeAndSaveImage($file, 'original', $this->ad, $index);
        });
    }

    private function resizeAndSaveImage($imageFile, $preSize = null, $ad, $index)
    {
        $stringSize = $this->stringfySize($preSize);
        $path = storage_path("app/ads");
        $img = Image::make($imageFile);

        if($preSize == 'original')
            return $img->save("{$path}/{$ad->uuid}_{$index}_{$stringSize}.jpg");

        $size = $preSize ?: $this->get_resize_size($img);
        $img->fit((int) $size);
        return $img->save("{$path}/{$ad->uuid}_{$index}_{$stringSize}.jpg");
    }

    private function getStorageDisk()
    {
        return App::environment('local') ? 'rackspace' : 'rackspace';
    }

    private function stringfySize($preSize)
    {
        $size = "original";
        if(is_null($preSize)) $size = "big";
        if($preSize == 100) $size = "small";
        return $size;
    }

    /**
     * @param $imageFile
     * @param $preSize
     * @return string
     */
    private function resizeImage($imageFile, $preSize, $ad)
    {
        $stringSize = $this->stringfySize($preSize);
        $path = storage_path("app/ads");
        $img = Image::make($imageFile);

        if($preSize == 'original') return $img->save("{$path}/{$ad->uuid}_{$stringSize}.jpg");

        $height = $preSize ?: $img->height();
        $img->fit($height);
        return $img->save("{$path}/{$ad->uuid}_{$stringSize}.jpg");
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getImage($key)
    {
        return Storage::disk('local')->get($key);
    }

    /**
     * @return array
     */
    private function moveImages()
    {
        $paths = [];
        for ($i = 1; $i <= $this->number_of_images; $i++){
            $path = "{$this->ad->uuid}_{$i}";
            $paths_by_sizes = $this->move_by_size($path);
            $paths = array_add($paths, $path, $paths_by_sizes);
        }
        return $paths;
    }

    /**
     * @return array
     */
    private function getSizes(){
        return [
            'small', 'big', 'original'
        ];
    }

    /**
     * @param $name
     * @return array
     */
    private function move_by_size($name)
    {
        $paths = [];
        foreach ($this->getSizes() as $size) {
            $path = "ads/{$name}_{$size}.jpg";
            var_dump($path);
            $file = $this->getImage($path);
            Storage::cloud()->put($path, $file);
            $path_url = $this->getUrlPath($path);
            var_dump($path_url);
            $paths = array_add($paths, $size, $path_url);
        }
        return $paths;
    }

    /**
     *
     */
    private function cleanDisk()
    {
        Storage::disk('local')->delete($this->images_paths);

        $path = storage_path('app/ads');
        $mask = "{$path}/{$this->ad->uuid}_*.*";
        array_map('unlink', glob($mask));
    }

    /**
     * @param $img
     * @return int|null
     */
    private function get_resize_size($img)
    {
        $size = null;
        $min_size = 300;
        $max_size = 500;

        $img_width = $img->width();
        $img_height = $img->height();

        if($img_height < $img_width){
            $size = $img_height;
        }elseif ($img_height > $img_width){
            $size = $img_width;
        }elseif ($img_height == $img_width){
            $size = $img_height;
        }

        if($size <= $min_size){
            return $min_size;
        }elseif ($size >= $max_size){
            return $max_size;
        }else{
            return $size;
        }
    }

    private function savePaths($paths)
    {
        collect($paths)->each(function($in_paths, $name) {
            $images = collect($in_paths)
                ->map(function($path, $size) use($name) {
                    return [
                        'ad_id' => $this->ad->id,
                        'size' => $size,
                        'path' => $path,
                        'name' => $this->extractImageName($path),
                        'main' => (int) explode("_", $name)[1] == 1
                    ];
                })
                ->values()->all();
            $this->ad->images()->createMany($images);
        });
    }

    private function getUrlPath($path)
    {
        $cloudPublicUrl = env("RACKSPACE_PUBLIC_CONTAINER_LINK");
        return "{$cloudPublicUrl}/{$path}";
    }

    /**
     * @param $path
     * @return mixed
     */
    private function extractImageName($path)
    {
        return collect(explode("/", $path))->last();
    }
}
