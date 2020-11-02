<?php

namespace App\Http\Controllers;

use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function getMessage()
    {
        return Message::with('user')->get();
    }

    public function broadcastMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();
        return response()->json(['status' => 'Message Sent']);
    }
}
