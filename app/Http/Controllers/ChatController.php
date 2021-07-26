<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function getUserChats(Request $request)
    {
        $chatsOrderByLastMessage = DB::select("
            SELECT chats.id, chats.name, chats.created_at, MAX(messages.created_at) AS last_message_date
            FROM chats
            INNER JOIN users_chats ON chats.id=users_chats.chat_id AND users_chats.user_id = ? 
            LEFT JOIN messages ON chats.id=messages.chat
            GROUP BY chats.id
            ORDER BY last_message_date DESC", [$request->user]
        );

        if (count($chatsOrderByLastMessage) === 0) {
            return response('User chats not found', 404);
        }

        return $chatsOrderByLastMessage;
    }

    public function create(ChatRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $chat = Chat::create([
                    'name' => $request->name
                ]);
                $users = User::whereIn('id', $request->users)->get();
                if (count($users) === 0) {
                    throw new \Exception('Users not found');
                }
                $chat->users()->attach($users);

                return $chat->id;
            });
        } catch (\Throwable $e) {
            return response('Operation Error: ' . $e->getMessage(), 422);
        }
    }
}
