<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Lors du clic sur le lien du nom+prenom une vue renvoie 
    // l'identité du commercial si il est connecté 
    // Sinon une vue avec un filtre sur l'id-user correspondant au lien cliqué est envoyée
    // Il n'y a pas d'autres fonctions à ce stade du Test
    
    public function profile(User $user)
    {
        if (Auth::check() && $user->id == Auth::user()->id)
        {
            return \view('auth.profile',$user);
        }
        else
        {
            $Annonces = Annonce::orderBy('id')->where('user_id', '=', $user->id)->paginate(3);
            $data = [
                'title'=>$user->last_name.'/'.$user->first_name.'/annonces',
                'description'=>config('app.name').'/'.$user->first_name.'/'.$user->last_name.'/annonces',
                'Annonces'=>$Annonces
            ];
            return view('annonce.index', $data);
        }
    }

}
