<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdImage;
use App\Commerce\Transformers\AdTransformer;
use App\Commerce\Transformers\UserPublicAdsTransformer;
use App\Events\AdWasSubmitted;
use App\Jobs\DeleteAdImages;
use App\Jobs\DownloadAdImages;
use App\Jobs\ProcessAdImages;
use Carbon\Carbon;
use Delight\Ids\Id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Ramsey\Uuid\Uuid;

class AdsController extends Controller
{
    /**
     * @var Ad
     */
    private $ad;
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * AdsController constructor.
     * @param Ad $ad
     * @param Manager $fractal
     */
    public function __construct(Ad $ad, Manager $fractal)
    {
        $this->ad = $ad;
        Carbon::setLocale(LaravelLocalization::getCurrentLocale());
        $this->fractal = $fractal;
    }

    public function multiple(Request $request)
    {
//        dd($request->all());
        return view('pages.ads.multiple');
    }

    public function single($id)
    {
        $ad = Ad::with('images', 'owner', 'category', 'owner.location')
            ->where('uuid', $id)
            ->first();
        $similar = Ad::with('images', 'category')
            ->where('category_id', $ad->category_id)
            ->where('title', 'like', "%{$ad->title}%")
            ->get()
            ->take(10);
//            ->reject(function($sad) use ($ad) {
//                return $ad->id == $sad->id;
//            });

        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer))->toArray()['data'];
        $similar_transformed = $this->fractal->createData(new Collection($similar, new UserPublicAdsTransformer))
            ->toArray()['data'];
//        dd($similar, $similar_transformed);
        return view('pages.ads.single', ['ad' => $transformed, 'similar_ads' => $similar_transformed]);
    }

    public function create()
    {
        return view('pages.ads.create');
    }

    public function save(Request $request)
    {
        if($request->get('location_id')){
            $this->updateUserLocation($request);
        }
        $data = $this->prepareData($request);
        //save ad
        $ad = Ad::create($data);
        //update ad with code
        $code = (new Id())->encode($ad->id);
        $ad->update(['code' => $code]);
        //save images
        $images_paths = $this->saveAdImagesForFurtherProcessing($request, $ad);
        $this->dispatch(new ProcessAdImages($ad, $images_paths, $request->image_length, auth('user')->user()));
        return $request->all();
    }

    public function edit($id)
    {
        $raw_ad = Ad::with('images')->where('uuid', $id)->first();
        if( !$raw_ad ) abort(404);

        $this->dispatch(new DownloadAdImages(auth('user')->user(), $raw_ad, "original"));

        $ad = Ad::with('category')->where('uuid', $id)
            ->get()
            ->map(function($ad){
//                dd($ad);
                return [
                    'id' => $ad['id'],
                    'code' => $ad['code'],
                    'title' => $ad['title'],
                    'category' => $this->getTranslatedAdCategory($ad['category']),
                    'condition' => $ad['condition'],
//                    'condition' => $ad['condition'] == 'used' ? 0 : 1,
                    'description' => $ad['description'],
                    'all_images' => $ad['images'],
                    'images' => $this->getAdOriginalImages($ad['images']),
                    'price' => [
                        'amount' => $ad['price'],
                        'negotiable' => $ad['negotiable']
                    ]
                ];
            })->first();

        if(!$ad) abort(404);

        return view('pages.ads.edit', ['ad' => $ad]);
    }

    public function update($id, Request $request)
    {
        $ad = Ad::find((int) $id);

        if(!$ad) abort(404);

        $ad->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'condition' => $request->condition ? 'new' : 'used',
            'description' => $request->description,
            'price' => $request->price,
            'negotiable' => $request->negotiable
        ]);

//        delete old original images
//        $this->deleteOldOriginalImages($ad);
        $images_paths = $this->saveAdImagesForFurtherProcessing($request, $ad);
        $this->dispatch(new ProcessAdImages($ad, $images_paths, $request->image_length, auth('user')->user()));

        dd($ad);
    }

    public function cancelUpdate($id)
    {
        $ad = Ad::with('images')->find($id);

        if(!$ad) return abort(404);

        $paths = collect($ad['images'])
            ->filter(function($img){
                return $img['size'] == 'original';
            })
            ->map(function($img){
            return "/ads/{$img['name']}";
        });

        $this->deleteAdImages($paths, 'public');

        return $paths;
    }

    public function report($uuid)
    {
        $ad = Ad::where('uuid', $uuid)->first();
        dd($ad);
    }

    public function favorite($uuid)
    {
        $ad = Ad::where('uuid', $uuid)->first();
        dd($ad);
    }

    public function delete($id)
    {
        $ad = Ad::find($id);

        if(!$ad) return abort(404);

        $paths = $ad->images->map(function($img){
            return $this->formatPath($img['path']);
        });

        $this->deleteAdImages($paths, 'rackspace');

        $ad->images()->delete();

        $ad->delete();

        return redirect()->route('user.profile', ['user_name' => auth('user')->user()->slug]);
    }

    private function prepareData(Request $request)
    {
        $uuid = Uuid::uuid4();
        return [
            'uuid' => $uuid,
            'title' => $request->title,
            'condition' => $request->condition,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::guard('user')->user()->id,
            'negotiable' => $request->negotiable == "true" ? true : false
        ];
    }

    /**
     * @param Request $request
     * @param $ad
     * @return array|null
     */
    private function saveAdImagesForFurtherProcessing(Request $request, $ad)
    {
        $img_paths = [];
        $total_images = (int)$request->image_length;
        for ($i = 1; $i <= $total_images; $i++) {
            $key = "image_{$i}";
            $uploadedFile = $request->file($key);

            $path = Storage::disk('local')
                ->putFileAs('ads', $uploadedFile, "{$ad->uuid}_{$i}.jpg");

            array_push($img_paths, $path);
        }
        return $img_paths;
    }

    /**
     * @param Request $request
     */
    private function updateUserLocation(Request $request)
    {
        auth('user')->user()->update(['location_id' => $request->get('location_id')]);
    }

    private function getTranslatedAdCategory($category)
    {
        $cat = collect($category->translate());
        return [
            'id' => $cat->get('category_id'),
            'name' => $cat->get('name')
        ];
    }

    private function getAdOriginalImages($images)
    {
        return collect($images)
            ->filter(function($img){
                return $img['size'] == 'original';
            })->map(function($img){
                $path = $img['path'];
                $name = $this->extractImageName($path);
                return ['path' => "/storage/ads/{$name}"];
            })->flatten()->toArray();
    }

    private function deleteAdExistingImages($ad)
    {
        $paths = $ad['all_images']->reject(function($img){
            return $img['size'] == 'original';
        })->map(function($img){
            return $this->formatPath($img['path']);
        });
//        dd($paths);
        foreach ($paths as $path){
            Storage::disk($this->getStorageDisk())->delete($path);
        }

//        dd($paths);

        AdImage::where('ad_id',$ad['id'])
            ->whereIn('size', ['small', 'big'])->delete();

    }

    private function getStorageDisk()
    {
        return App::environment('local') ? 'dropbox' : 's3';
    }

    private function deleteOldOriginalImages($ad)
    {
        $paths = $ad['images'];
        $this->dispatch(new DeleteAdImages($paths, 'rackspace'));
        AdImage::where('ad_id',$ad['id'])
            ->where('size', 'original')->delete();
    }

    private function formatPath($path)
    {
        $name = collect(explode("/", $path))
            ->last();

        return "/ads/{$name}";
    }

    /**
     * @param array $paths
     * @param string $disk
     */
    private function deleteAdImages($paths, $disk)
    {
        $this->dispatch(new DeleteAdImages($paths, $disk));
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
