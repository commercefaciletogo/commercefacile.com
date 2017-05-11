<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Admin;
use App\Role;
use App\User;
use Commerce\Transformers\Admin\AdTransformer;
use Commerce\Transformers\Admin\UsersTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class AdminPagesController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * AdminPagesController constructor.
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function dashboardPage()
    {
        return view('admin.pages.dashboard');
    }

    public function adsPage()
    {
        return view('admin.pages.ads');
    }

    public function adPage($uuid, Request $request)
    {
        if(!$request->has('action')) return redirect()->route('admin.ads');

        $ad = Ad::with('images', 'category', 'owner')->where('uuid', $uuid)->first();
        if(!$ad) return redirect()->route('admin.ads');

        $transformed_ad = $this->fractal->createData(new Item($ad, new AdTransformer))->toArray()['data'];

//        dd($transformed_ad);

        if($request->get('action') == 'view' && $ad->status == 'online'){
            return view('admin.pages.ad.view', ['ad' => $transformed_ad]);
        }elseif($request->get('action') == 'review'){
            return view('admin.pages.ad.review', ['ad' => $transformed_ad]);
        }

        return redirect()->route('admin.ads');
    }

    public function employeesPage()
    {
        $employees = Admin::all()
            ->reject(function($employee){
            return $employee->id == auth('admin')->user()->id;
        })
        ;
        $roles = Role::all();
        return view('admin.pages.employees', ['employees' => $employees, 'roles' => $roles]);
    }

    public function usersPage()
    {
        $users = User::with('location', 'ads')->get()->sortByDesc('created_at');
        $transformed = (new Manager())->createData(new Collection($users, new UsersTransformer()))->toArray()['data'];
        return view('admin.pages.users', ['users' => $transformed]);
    }

    public function usersSearch()
    {
        // dd(request()->all());
        $q = request()->get('q');
        $user = User::with('ads')->where('phone', $q)->first();
        if(!$user) return ['incomplete_results' => false, 'items' => []];

        return response()->json([
            'incomplete_results' => false,
            'items' => [
                [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'ads' => $user->ads->count()
                ]
            ]
        ]);
    }
}
