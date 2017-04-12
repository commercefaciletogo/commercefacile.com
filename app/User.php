<?php

namespace App;

use App\Notifications\UserResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'slug', 'location_id', 'uuid', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class, 'user_id');
    }

    public function reported_ads()
    {
        return $this->belongsToMany(Ad::class, 'reported_ads', 'user_id', 'ad_id')->withTimestamps();
    }

    public function favorite_ads()
    {
        return $this->belongsToMany(Ad::class, 'favorite_ads', 'user_id', 'ad_id')->withTimestamps();
    }
}
