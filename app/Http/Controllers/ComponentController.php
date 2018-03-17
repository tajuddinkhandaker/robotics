<?php

namespace Robotics\Http\Controllers;

use Robotics\Component;
use Illuminate\Http\Request;

use Log;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $states = Component::pluck('state')->map(function($item, $index) { return $item == 'ON' ? 1 : 0; });
        return response()->json([ 'lights' => $states->toArray() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $c = new Component;
        $c->name = $request->input('name');
        if ($c->save())
        {
            return response()->json([ 'data' => [ 'message' => 'New component ('.$c->name.') is added.' ] ]);
        }
        return response()->json([ 'data' => [ 'message' => 'Component add failed.' ] ]);
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
     * Show the form for editing the specified resource.
     *
     * @param  \Robotics\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function edit(Component $component)
    {
        //
        $component->state = $component->state == 'ON' ? 'OFF' : 'ON';
        if ($component->save())
        {
            return response()->json([ 'data' => [ 'message' => $component->name.' is switched.', 'switch_state' => $component->state ] ]);
        }
        return response()->json([ 'data' => [ 'message' => $component->name.' is failed to switch.' ] ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Robotics\Component  $component
     * @return \Illuminate\Http\Response
     */
    public function destroy(Component $component)
    {
        //
    }

    public function states()
    {
        $states = Component::pluck('state')->map(function($item, $index) { return $item == 'ON' ? 1 : 0; });
        return response()->json([ 'lights' => $states->toArray() ]);
    }

    public function log(Request $request)
    {
        Log::info('[ip:'.$request->ip().'][client-id:'.$request->input('client_id').'][http-code:'.$request->input('http_code').']['.$request->input('ḿessage').']');
        return response()->json([ 'data' => [ 'log' => [ 'is_sent' => true ] ] ]);
    }
}   
