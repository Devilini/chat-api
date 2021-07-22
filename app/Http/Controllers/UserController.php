<?php

namespace App\Http\Controllers;

use \App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function create(UserRequest $request)
    {
        return User::create([
            'username' => $request->username
        ])->id;
    }
}
