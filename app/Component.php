<?php

namespace Robotics;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['componentable'];
    
    /**
     * Get all of the owning componentable models.
     */
    public function componentable()
    {
        return $this->morphTo();
    }

    /**
     * Get all components those belongs to the owning bot clients.
     */
    public function scopeWithInComponentable($query, array $componentableIds)
    {
    	return $query->with(['componentable' => function ($query) use ($componentableIds) {
            $query->whereIn('id', $componentableIds);
        }])->get()->map(function($component, $index) { return  [
            'id' => $component->id,
            'name' => $component->name,
            'type' => $component->type,
            'state' => $component->state,
            'bot_id' => $component->componentable_id
        ]; });
    }

    public static function getStatesWithInComponentable(array $botclientIds)
    {
    	return Component::withInComponentable($botclientIds)
                                            ->pluck('state')->map(function($item, $index) { return $item == 'ON' ? 1 : 0; });
    }

    public static function getRules()
    {
    	return [
            'name' => 'bail|required|min:4|max:255',
            'type' => 'in:LIGHT,FAN',
            'state' => 'in:OFF,ON',
            'bot_id' => 'required|exists:oauth_clients,id',
        ];
    }
}
