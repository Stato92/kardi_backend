<?php

namespace App\Http\Controllers;

use App\Providers\StatusCreated;
use App\Providers\StatusDeleted;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $status = Status::create([
            'name' => $request->name,
            'user_id' => \App\User::findOrFail($request->user_id)->id,
            'patient_id' => \App\Patient::findOrFail($request->patient_id)->id,
            'priority' => $request->priority,
        ]);
        $status->loadMissing('user:id,name,surname');
        broadcast(new StatusCreated($status));
        return $status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $status = Status::findOrFail($request->id);
            broadcast(new StatusDeleted($status))->toOthers();
            $status->delete();
            return new Response(null,204);
    }
}
