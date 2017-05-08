<?php

namespace App\Jobs;

use App\Ad;
use App\AdImage;
use App\Events\AdWasSubmitted;
use App\Events\AdsWereUpdated;
use App\Events\ProcessingAdImages;
use Delight\Ids\Id;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
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
    private $creating;
    /**
     * @var
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param $images_paths
     * @param $number_of_images
     * @param $user
     * @param bool $creating
     * @param $data
     */
    public function __construct($images_paths, $number_of_images, $user, $data, $creating = true)
    {
        $this->number_of_images = $number_of_images;
        $this->images_paths = $images_paths;
        $this->user = $user;
        $this->creating = $creating;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            DB::transaction(function(){
                event(new ProcessingAdImages($this->user, 10));
                //save ad
                if($this->creating){
                    $ad = Ad::create($this->data);
                }else{
                    $ad = Ad::find($this->data['ad_id']);
                    $ad->update([
                        'category_id' => $this->data['category_id'],
                        'title' => $this->data['title'],
                        'condition' => $this->data['condition'],
                        'description' => $this->data['description'],
                        'price' => $this->data['price'],
                        'negotiable' => $this->data['negotiable']
                    ]);
                }
                //update ad with code
                if($this->creating) event(new ProcessingAdImages($this->user, 30));
                if($this->creating) $code = (new Id())->encode($ad->id);
                if($this->creating)  $ad->update(['code' => $code]);
                event(new ProcessingAdImages($this->user, 50));
                //save images
                $this->saveAdImages($ad);
                $paths = $this->moveImages($ad);
                event(new ProcessingAdImages($this->user, 90));
                $this->cleanDisk($ad);
                $this->savePaths($paths, $ad);
                event(new ProcessingAdImages($this->user, 100));
            });
            event(new AdsWereUpdated());
            event(new AdWasSubmitted($this->user, true));
        }catch (\Exception $e){
            event(new AdWasSubmitted($this->user, false));
            var_dump($e->getLine(), $e->getMessage());
        }
    }

    /**
     *
     */
    private function saveAdImages($ad)
    {
        collect($this->images_paths)->each(function($path, $key) use($ad){
            if(!Storage::disk('local')->exists($path)) return false;
            $index = $key + 1;
            $file = $this->getImage($path);

            $this->resizeAndSaveImage($file, 100, $ad, $index);
            $this->resizeAndSaveImage($file, null, $ad, $index);
            $this->resizeAndSaveImage($file, 'original', $ad, $index);
        });
    }

    private function resizeAndSaveImage($imageFile, $preSize = null, $ad, $index)
    {
        $stringSize = $this->stringfySize($preSize);
        $path = storage_path("app/ads");
        $img = Image::make($imageFile);

        if($preSize == 'original')
            return $img->save("{$path}/{$ad->uuid}_{$index}_{$stringSize}.jpg");

        $watermark = Image::make(storage_path('/watermark.png'));

        $size = $preSize ?: $this->get_resize_size($img);
        $img->insert($watermark, 'center')
            ->resize((int) $size, null, function($c){
                $c->aspectRatio();
                $c->upsize();
            });
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
    private function moveImages($ad)
    {
        $paths = [];
        for ($i = 1; $i <= $this->number_of_images; $i++){
            $path = "{$ad->uuid}_{$i}";
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
    private function cleanDisk($ad)
    {
        Storage::disk('local')->delete($this->images_paths);

        $path = storage_path('app/ads');
        $mask = "{$path}/{$ad->uuid}_*.*";
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

    private function savePaths($paths, $ad)
    {
        collect($paths)->each(function($in_paths, $name) use ($ad){
            $images = collect($in_paths)
                ->map(function($path, $size) use($name, $ad) {
                    return [
                        'ad_id' => $ad->id,
                        'size' => $size,
                        'path' => $path,
                        'name' => $this->extractImageName($path),
                        'main' => (int) explode("_", $name)[1] == 1
                    ];
                })
                ->values()->all();
            $ad->images()->createMany($images);
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
