<?php
/**
 * Created by PhpStorm.
 * User: guru
 * Date: 4/12/17
 * Time: 7:13 AM
 */

namespace Commerce\Transformers\Admin;


use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class UsersTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'email' => $user->email,
            'name' => $user->name,
            'location' => $user->location ? $user->location->name : 'N/A',
            'status' => $user->status,
            'date' => Carbon::parse($user->created_at)->toFormattedDateString(),
            'phone' => $user->phone,
            'total_ads' => $user->ads->count(),
            'slug' => $user->slug,
            'id' => $user->id,
        ];
    }

}