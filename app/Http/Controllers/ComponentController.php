<?php

namespace Robotics\Http\Controllers;

use Robotics\Component;
use Robotics\BotClient;

use Illuminate\Http\Request;

use Auth;
use Log;
use Carbon\Carbon;

class ComponentController extends Controller
{
    private static function getUserRegisteredComponents($user)
    {
        return [ 'data' => Component::withInComponentable($user->getRegisteredBotIds()->toArray())->toArray() ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // {"data":[{"id":1,"name":"BedLight","type":"LIGHT","state":"OFF"}]}
        return response()->json(self::getUserRegisteredComponents($request->user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Component::getRules());
        $c = new Component;
        $c->name = $request->name;
        $c->type = $request->type;
        $c->componentable()->associate(BotClient::find($request->bot_id));
        return $c->save() ? $c : null;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Robotics\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function show(Component $component)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Robotics\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Component $component)
    {
        if (!$component)
            return null;
        $this->validate($request, Component::getRules());
        $component->state = $request->state;
        $component->type = $request->type;
        $component->name = $request->name;
        return $component->save() ? $component : null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Robotics\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        return $component && $component->delete() ? $component : null;
    }

    public function states(BotClient $botclient)
    {
        $updatedAt = $botclient->updated_at->timezone('Asia/Dhaka');
        $now = Carbon::now()->timezone('Asia/Dhaka');
        $updated = ($now->second - $updatedAt->second) <= 10;
        Log::info('Updated '. $updatedAt->diffForHumans() );
        Log::info($updated ? 'device status updated' : 'device status remained');
        return response()->json([ 
            'lights' => $updated ? Component::getStatesWithInComponentable([ $botclient->id ])->toArray() : [],
            'updated' => $updated
        ]);
    }

    public function log(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'present',
            'http_code' => 'present',
            'message' => 'present|min:1',
        ]);
        Log::info('[ip:'.$request->ip().'][client-id:'.$request->input('client_id').'][http-code:'.$request->input('http_code').']['.$request->input('ḿessage').']');
        return response()->json([ 'data' => [ 'log' => [ 'is_sent' => true ] ] ]);
    }
}   
