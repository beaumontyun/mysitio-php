<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return Message::with('user')->get();
    }

    public function store(Request $request)
    {
        $user = $request->user()->id;

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        // send event to listenders
        broadcast(new MessageSentEvent($message, $user))->toOthers();

        return [
            'message' => $message,
            'user' => $user,
        ];
    }
}
