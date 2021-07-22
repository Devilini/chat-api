<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function getMessage(Request $request)
    {
        $messages =  Message::where('chat', $request->chat)
            ->with('user:id,username', 'chat:id,name')
            ->oldest()
            ->get();

        if (is_null($messages)) {
            return response('Messages not found', 404);
        }

        return $messages;
    }

    public function create(MessageRequest $request)
    {
        $userInTheChat = DB::table('users_chats')
            ->where('chat_id', $request->chat)
            ->where('user_id',  $request->author)
            ->exists();

        if (!$userInTheChat) {
            return response('User is not in the chat', 404);
        }

        return Message::create([
            'chat' => $request->chat,
            'author' => $request->author,
            'text' => $request->text,
        ])->id;
    }
}
