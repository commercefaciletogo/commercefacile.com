<?php

namespace Commerce\Transformers\Admin;

use App\Admin;
use App\User;
use League\Fractal\TransformerAbstract;

class AgentTransformer extends TransformerAbstract 
{

    public function transform(Admin $agent)
    {
        return [
            'id' => $agent->id,
            'name' => $agent->name,
            'email' => $agent->email,
            'link' => $agent->meta->link,
            'total_subs' => $agent->subscribers->count(),
            'subscribers' => $this->get_subscribers($agent)
        ];
    }

    private function get_subscribers(Admin $agent)
    {
        return $agent->subscribers->map(function($sub){
            $user = User::with('ads')->find($sub['user_id']);
            return [
                'id' => $user->id,
                'phone' => $user->phone,
                'date' => $user->created_at->toFormattedDateString(),
                'ads' => $user->ads->count()
            ];
        })->sortByDesc('id')->toArray();
    }
}