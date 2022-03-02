<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct()
    {
       $this->middleware('guest');
    }

    // formulaire de connexion
    // la page index renvoie la vue formulaire de connexion
    // app.name récupère la variable d'environnement dans le fichier /.env (je l'ai nommé 3Gimmo)
    // par défaut app.name est déclaré dans le fichier config/app.php (app.name = laravel par défaut)

    public function index()
    {
        $data = [
            'title'=>'Connexion - '.config('app.name'),
            'description'=>'connexion à votre compte '.config('app.name'),
        ];
        return view('auth.login', $data);
    }
       
    // Après validation des identifiants
    // on récupère la variable remember à True or False suivant si l'utilisateur a coché l'option "se souvenir de moi"
    // $remember = request()->has('remember');

    public function login()
    {
        request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            return redirect('profile/mesannonces');
        }
        return back()->withError('Erreur dans les identifiants!')->withInput();
        // facultatif '->withInput()' renvoie email dans le formulaire pour éviter de le resaisir si besoin
    }
}
