<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentSubscriber extends Model
{
    protected $fillable = ['agent_id', 'user_id'];
}
