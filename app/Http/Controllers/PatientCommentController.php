<?php

namespace App\Http\Controllers;

use App\PatientComment;
use App\Providers\PatientCommentCreated;
use App\Providers\PatientCommentDeleted;
use App\Providers\PatientCommentEdited;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PatientCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:65255',
//            'item_id' => 'required|exists:patients,id',
        ]);
        $comment = PatientComment::create([
            'content' => $request->content,
            'patient_id' => $request->id,
            'user_id' => Auth::user()->id,
        ]);
        $comment->loadMissing('user:id,name,surname');
        broadcast(new PatientCommentCreated($comment))->toOthers();
        return $comment;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $patientComment = PatientComment::findOrFail($request->id);
        $request->validate([
            'content' => 'required|string|max:65255',
        ]);
        if ($patientComment->user->id === Auth::User()->id) {
            $patientComment->content = $request->content;
            $patientComment->save();
            $patientComment->loadMissing('user:id,name,surname');
            broadcast(new PatientCommentEdited($patientComment))->toOthers();
            return new Response($patientComment,200);
        } else {
            return new Response('Unauthorized',301);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $patientComment = PatientComment::findOrFail($request->id);
        if ($patientComment->user->id === Auth::User()->id) {
            broadcast(new PatientCommentDeleted($patientComment))->toOthers();
            $patientComment->delete();
            return new Response(null,204);
        } else {
            return new Response('Unauthorized',301);
        }
    }
}
