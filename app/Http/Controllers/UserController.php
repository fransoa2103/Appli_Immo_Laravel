<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Lors du clic sur le lien du nom+prenom une vue renvoie 
    // l'identité du commercial connecté.
    // Il n'y a pas d'autres fonctions à ce stade du Test
    
    public function profile(User $user)
    {
        return "<h1>Vous êtes sur le profil de ".$user->first_name." ".$user->last_name."</h1>";
    }

}
