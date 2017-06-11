<?php

namespace Commerce\Transformers\Admin;

use App\Admin;
use League\Fractal\TransformerAbstract;

class AgentsTransformer extends TransformerAbstract 
{

    public function transform(Admin $agent)
    {
        return [
            'id' => $agent->id,
            'name' => $agent->name,
            'email' => $agent->email,
            'token' => $agent->meta->token,
            'link' => $agent->meta->link,
            'subscribers' => $agent->subscribers->count()
        ];
    }
}