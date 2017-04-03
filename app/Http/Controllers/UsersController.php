<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Category;
use App\Commerce\Transformers\ProfileAdsTransformer;
use App\Commerce\Transformers\UserPublicAdsTransformer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class UsersController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * UsersController constructor.
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function profile($user_name)
    {
        $user = $this->user_exist($user_name);
        $ads = User::with('ads.category', 'ads.images', 'ads.rejected')
            ->find($user['id'])->ads;

        $tranformed = $this->fractal->createData(new Collection($ads, new ProfileAdsTransformer))->toArray()['data'];

        return view('user.profile', ['user' => $user, 'ads' => $tranformed]);
    }

    public function settings($user_name)
    {
        $user = $this->user_exist($user_name);
        return view('user.settings', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('user')->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'phone' => [
                'required',
                'regex:/[0-9]{8}/',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'email',
                Rule::unique('users')->ignore($user->id)
            ]
        ]);
        if($validator->fails()) return response()->json(['error' => $validator->errors()])->setStatusCode(401);

        if(! $user->update($data)) return response()->json(['updated' => false]);

        return response()->json(['updated' => true]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('user')->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        if($validator->fails())
            return response()->json(['error' => $validator->errors()])->setStatusCode(401);

        if(! Auth::guard('user')->attempt(['phone' => $user->phone, 'password' => $data['old_password']]))
            return response()->json(['updated' => false]);

        if(!$user->update(['password' => bcrypt($data['password'])]))
            return response()->json(['updated' => false]);

        return response()->json(['updated' => true]);
    }

    public function favorites($user_name)
    {
        $user = $this->user_exist($user_name);
        return view('user.favorites', ['user' => $user]);
    }

    public function publicProfile($user_name)
    {
        $user = $this->user_exist($user_name);

        $ads = Ad::with('images', 'owner')
            ->where(['user_id' => $user['id'], 'status' => 'online'])
            ->get();

        $transformed = $this->fractal->createData(new Collection($ads, new UserPublicAdsTransformer))
            ->toArray()['data'];

        $total_online_ads = collect($transformed)->count();

        $transformed = collect($transformed)->groupBy(function($item){
            if(is_null($item['category']['parent'])) return $item['category']['name'];
            return $item['category']['parent']['name'];
        })->toArray();

//        dd($transformed);

        return view('user.public-profile', ['user' => $user, 'categories' => $transformed, 'total' => $total_online_ads]);
    }

    /**
     * @param $user_name
     * @return array
     */
    private function user_exist($user_name)
    {
        $user = User::with('location')->where('slug', $user_name)->first();
        if (!$user) abort(404);
        return [
            'id' => $user->id,
            'slug' => $user->slug,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'location' => $user->location ? [
                'id' => $user->location->id,
                'name' => $user->location->name
            ] : ['id' => '', 'name' => '']
        ];
    }

    private function getTranslatedAdCategory($category)
    {
        return $category->translate();
    }

    private function getAdSmallMainImage($images)
    {
        return collect($images)
            ->filter(function($image){
                return $image['size'] == 'small' && $image['main'] == 1;
            })->first()->path;
    }

    private function getTranslatedAdMainCategory(Category $category)
    {
        if(is_null($category['parent_id'])) return $this->getTranslatedAdCategory($category);

        return $category->parent->translate();
    }
}
