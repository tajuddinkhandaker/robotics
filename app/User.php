<?php

namespace Robotics;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Get all of the clients.
     */
    public function botclients()
    {
        return $this->hasMany('Robotics\BotClient');
    }

    public function getRegisteredBotIds()
    {
        return $this->botclients->pluck('id')->map(function ($id, $key) { return $id; });
    }

}
