<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Events\AdsWereUpdated;
use App\RejectedAd;
use Carbon\Carbon;
use Commerce\Transformers\Admin\AdsTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

class AdsApiController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * AdsApiController constructor.
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function all(Request $request)
    {
        $paginator = $this->get_paginated_ads($request);
        $transformed = $this->fractal
            ->createData(new Collection($paginator->getCollection(), new AdsTransformer))
            ->toArray();
        $data = collect($paginator)->toArray();
        $data['data'] = $transformed['data'];
        return $data;
    }

    public function status()
    {
        event(new AdsWereUpdated());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function get_paginated_ads(Request $request)
    {
        if ($request->has('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->get('sort'));
            $query = Ad::with(['owner', 'images', 'category', 'category.parent'])
                ->orderBy($sortCol, $sortDir);
        } else {
            $query = Ad::with(['owner', 'images', 'category', 'category.parent'])
                ->orderBy('updated_at', 'desc');
        }

        if($request->exists('q')){
            $query->where(function ($q) use ($request) {
                    $query = "%{$request->q}%";
                    $q->where('code' , $request->q)
                        ->orWhere('title', 'like', $query);
            });
        }

        if ($request->exists('filter')) {
            if(collect(['pending', 'online', 'offline', 'rejected'])->contains($request->filter)){
                $query->where(function ($q) use ($request) {
                    $value = $request->filter;
                    $q->where('status', $value);
                });
            }else{
                $query->where(function ($q) use ($request) {
                    $q->whereIn('status', ['pending', 'rejected', 'online']);
                });
            }
        } else {
            $query->where(function ($q) use ($request) {
                $q->whereIn('status', ['pending', 'rejected', 'online']);
            });
        }

        $perPage = $request->has('per_page')
            ? (int)$request->get('per_page')
            : null;

        $data = $query->paginate($perPage);
        return $data;
    }

    public function review($id, Request $request)
    {
        $rejecteds = collect($request->all())->filter(function ($v, $k) {
            return $v == "false";
        });

        if($rejecteds->isEmpty()){
            $this->publish_ad($id);
        }else{
            $data = $rejecteds->map(function($v, $k){
                return $k;
            })->keys()->toArray();
            $fields = implode($data, ".");
            $this->reject_ad($id, $fields);
        }
        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $deleted = Ad::find($id)->delete();
        return ['deleted' => $deleted];
    }

    /**
     * @param $id
     * @param $fields
     */
    private function reject_ad($id, $fields)
    {
        $data = [
            'status' => 'rejected',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(3)
        ];
        Ad::find($id)->update($data);
        RejectedAd::create(['ad_id' => $id, 'fields' => $fields]);
        $this->status();
    }

    /**
     * @param $id
     */
    private function publish_ad($id)
    {
        $data = [
            'status' => 'online',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addWeek()
        ];
        Ad::find($id)->update($data);
        $this->status();
    }
}
