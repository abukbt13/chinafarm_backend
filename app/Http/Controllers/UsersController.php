<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function showUsers()
    {
        $users=User::with('detail')->get();
        return response()->json([
            'status'=>'success',
            'users' => $users
        ]);

    }
}
