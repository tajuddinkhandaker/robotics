<?php

namespace Robotics;

use Laravel\Passport\Client as AuthClient;
use Illuminate\Database\Eloquent\Model;

class BotClient extends AuthClient
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get all of the client's components.
     */
    public function components()
    {
        return $this->morphMany('Robotics\Component', 'componentable');
    }

    public function user()
    {
    	return $this->belongsTo('Robotics\User');
    }
}
