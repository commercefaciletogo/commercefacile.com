<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentMeta extends Model
{
    protected $fillable = ['agent_id', 'link', 'token']; 

    public function agent()
    {
        return $this->belongsTo(Admin::class, 'agent_id');
    }
}
