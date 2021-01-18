<?php

namespace App\Http\Controllers;

use App\ChatMessage;
use App\Providers\ChatMessageCreated;
use App\Providers\ChatMessageDeleted;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Response(\App\ChatMessage::all()->loadMissing('user:id,name,surname'));
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,emoji,file,system',
            'data' => 'required',
        ]);
        $message = ChatMessage::create([
            'type' => $request->type,
            'data' => json_encode($request->data),
            'user_id' => Auth::user()->id,
        ]);
        $message->loadMissing('user:id,name,surname');
        broadcast(new ChatMessageCreated($message))->toOthers();
        return $message;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $chatMessage = ChatMessage::findOrFail($request->id);
        if ($chatMessage->user->id === Auth::User()->id) {
            broadcast(new ChatMessageDeleted($chatMessage))->toOthers();
            $chatMessage->delete();
            return new Response(null,204);
        } else {
            return new Response('Unauthorized',301);
        }
    }
}
