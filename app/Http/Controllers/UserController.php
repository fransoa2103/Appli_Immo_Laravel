<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(){
        // return "<h1>je suis l'utilisateur numéro #".$user->name."</h1>";
        return "<h1>je suis l'utilisateur numéro </h1>";
    }

}
