<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile(User $user)
    {
        return "<h1>Vous êtes sur le profil de ".$user->first_name." ".$user->last_name."</h1>";
    }

}
