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
        $chatsWithMessages = DB::select("SELECT chats.id, chats.name, chats.created_at FROM chats INNER JOIN messages ON chats.id=messages.chat 
                                WHERE chats.id IN(SELECT chat_id FROM users_chats WHERE user_id = ?)
                                ORDER BY messages.created_at DESC", [$request->user]
        );

        $user = User::findOrFail($request->user);
        $chatsWithoutMessages = $user->chats()->doesntHave('messages')->get()->toArray();

        // Слитие чатов с сообщениями и без сообщенгий
        // Пока такой подход из-за сортировки чатов по дате последнего сообщения
        $chats= array_merge($chatsWithoutMessages, $chatsWithMessages);
        if (count($chats) === 0) {
            return response('User chats not found', 404);
        }

        return $chats;
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
        } catch (\Exception $e) {
            return response('Operation Error: ' . $e->getMessage(), 501);
        }
    }
}
