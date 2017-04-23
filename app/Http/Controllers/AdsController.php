<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdImage;
use App\Category;
use App\Commerce\Transformers\AdsTransformer;
use App\Commerce\Transformers\AdTransformer;
use App\Commerce\Transformers\UserPublicAdsTransformer;
use App\Events\AdWasSubmitted;
use App\Jobs\DeleteAdImages;
use App\Jobs\DownloadAdImages;
use App\Jobs\ProcessAdImages;
use App\Location;
use Arcanedev\Localization\Facades\Localization;
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
        Carbon::setLocale(Localization::getCurrentLocale());
        $this->fractal = $fractal;
    }

    /**
     * @return array
     */
    public function search()
    {
        $perPage = 15;
        $query = null;

        $searchQuery = request()->get('q');

        $perPage = request()->has('p')
            ? (int) request()->get('p')
            : $perPage;

        if(is_null($searchQuery)){
            $query = Ad::where('status', 'online');
        }else{
            $query = Ad::search($searchQuery)->where('status', 'online');
        }

        if(request()->has('trier') || request()->has('sort')){
            $s = request()->get('trier') ?: request()->get('sort');
            if($s == 'l'){
                $query = $query->orderBy('price', 'asc');
            }

            if($s == 'r'){
                $query = $query->orderBy('start_date', 'desc');
            }
        }

        $collection = $query->get();
        $paginator = $query->paginate($perPage);
        $transformed = $this->fractal->createData(new Collection($collection, new AdsTransformer))->toArray()['data'];
        $result = collect($paginator)->toArray();
        $result['data'] = $transformed;

        if(request()->has('c')){
            $categories = [];
            $category_uuid = request()->get('c');
            $category = Category::with('parent', 'children')->where('uuid', $category_uuid)->first();

            if($category){
                if($category->children->isNotEmpty()){
                    $categories = $category->children->map(function($category){
                        return $category->id;
                    });
                }

                if($category->children->isEmpty()){
                    array_push($categories, $category->id);
                }
            }

            $result['data'] = collect($result['data'])->filter(function($ad) use ($categories) {
                return collect($categories)->contains($ad['category_id']);
            })->toArray();
        }

        if(request()->has('l')){
            $locationUuid = request()->get('l');
            $location = Location::with('parent')->where('uuid', $locationUuid)->first();

            if($location){
                $result['data'] = collect($result['data'])->filter(function($ad) use ($location) {
                    return $ad['owner']['location']['id'] == $location->id;
                })->toArray();
            }
        }

        if(request()->has('page')){
            $result['data'] = collect($result['data'])->forPage(request()->get('page'), $perPage)->toArray();
        }

        return $result;
    }

    public function multiple()
    {
        return view('pages.ads.multiple');
    }

    public function single($id)
    {
        $ad = Ad::with('images', 'owner', 'category', 'owner.location')
            ->where('uuid', $id)
            ->first();
        if(! $ad) abort(404);
        $similar = Ad::with('images', 'category')
            ->where('category_id', $ad->category_id)
            ->orWhere('title', 'like', "%{$ad->title}%")
            ->get()
            ->take(10)
            ->reject(function($sad) use ($ad) {
                return $ad->id == $sad->id;
            });

        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer(auth('user')->user())))->toArray()['data'];
        $similar_transformed = $this->fractal->createData(new Collection($similar, new UserPublicAdsTransformer))
            ->toArray()['data'];
        return view('pages.ads.single', ['ad' => $transformed, 'similar_ads' => $similar_transformed]);
    }

    public function create()
    {
        return view('pages.ads.create');
    }

    public function save()
    {
        if(request()->get('location_id')){
            $this->updateUserLocation(request());
        }
        $data = $this->prepareData(request());
        //save ad
        $ad = Ad::create($data);
        //update ad with code
        $code = (new Id())->encode($ad->id);
        $ad->update(['code' => $code]);
        //save images
        $images_paths = $this->saveAdImagesForFurtherProcessing(request(), $ad);
        $this->dispatch(new ProcessAdImages($ad, $images_paths, request()->image_length, auth('user')->user()));
        return ['done' => true];
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
                    'condition' => $ad['condition'] == 'used' ? 0 : 1,
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

    public function update($id)
    {
        $ad = Ad::find((int) $id);

        if(!$ad) abort(404);

        $ad->update([
            'category_id' => request()->category_id,
            'title' => request()->title,
            'condition' => request()->condition == 1 ? 'new' : 'used',
            'description' => request()->description,
            'price' => request()->price,
            'negotiable' => request()->negotiable
        ]);

        $images_paths = $this->saveAdImagesForFurtherProcessing(request(), $ad);
        $this->dispatch(new ProcessAdImages($ad, $images_paths, request()->image_length, auth('user')->user()));

        return ['done' => true];
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
        if(is_null($ad)) return ['done' => false];
        $ad->reporters()->attach(auth('user')->user()->id);
        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer(auth('user')->user())))->toArray()['data'];
        return ['done' => true, 'ad' => $transformed];
    }

    public function dereport($uuid)
    {
        $ad = Ad::where('uuid', $uuid)->first();
        if(is_null($ad)) return ['done' => false];
        $ad->reporters()->detach(auth('user')->user()->id);
        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer(auth('user')->user())))->toArray()['data'];
        return ['done' => true, 'ad' => $transformed];
    }

    public function favorite($uuid)
    {
        $ad = Ad::where('uuid', $uuid)->first();
        if(is_null($ad)) return ['done' => false];
        $ad->favoritors()->attach(auth('user')->user()->id);
        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer(auth('user')->user())))->toArray()['data'];
        return ['done' => true, 'ad' => $transformed];
    }

    public function unfavorite($uuid)
    {
        $ad = Ad::where('uuid', $uuid)->first();
        if(is_null($ad)) return ['done' => false];
        $ad->favoritors()->detach(auth('user')->user()->id);
        $transformed = $this->fractal->createData(new Item($ad, new AdTransformer(auth('user')->user())))->toArray()['data'];
        return ['done' => true, 'ad' => $transformed];
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

    private function prepareData($request)
    {
        $uuid = Uuid::uuid4();
        return [
            'uuid' => $uuid,
            'title' => $request->title,
            'condition' => $request->condition == 1 ? 'new' : 'used',
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::guard('user')->user()->id,
            'negotiable' => $request->negotiable == "true" ? true : false
        ];
    }

    /**
     * @param $ad
     * @return array|null
     */
    private function saveAdImagesForFurtherProcessing($request, $ad)
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
     * @param $request
     */
    private function updateUserLocation($request)
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
                return "/storage/ads/{$name}";
            })->unique()->toArray();
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
