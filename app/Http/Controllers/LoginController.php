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
    public function index()
    {
        // la page index renvoie simplement à la vue du formulaire de connexion
        // app.name récupère la variable d'environnement dans le fichier /.env (je l'ai nommé 3Gimmo)
        // par défaut app.name est déclaré dans le fichier config/app.php (app.name = laravel par défaut)
        $data = [
            'title'=>'Connexion - '.config('app.name'),
            'description'=>'connexion à votre compte '.config('app.name'),
        ];
        return view('auth.login', $data);
    }
       
    public function login()
    {
        request()->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
        // Après validation des identifiants
        // on récupère la variable remember à True or False suivant si l'utilisateur a coché l'option "se souvenir de moi"
        // $remember = request()->has('remember');

        if(Auth::attempt(['email'=>request('email'), 'password'=>request('password')])){
            return redirect('/');
        }
        return back()->withError('Erreur dans les identifiants!')->withInput();
        // facultatif '->withInput()' renvoie email dnas le formulaire pour éviter de le resaisir si besoin
    }
}
