<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest');
    }
    
    // formulaire d'inscription
    public function index(){
        // la page index renvoie simplement à la vue du formulaire d'inscription
        // app.name récupère la variable d'environnement dans le fichier /.env (je l'ai nommé 3Gimmo)
        // par défaut app.name est déclaré dans le fichier config/app.php (app.name = laravel par défaut)
        $data = [
            'title'=>'Inscription',
            'description'=>'Inscription sur le site '.config('app.name'),
        ];
        return view('auth.register', $data);
    }

    // traitement du formulaire d'inscription
    public function register(Request $request){
        
        // $request->all(); équivaut à request()->all(), request() étant la méthode helper
        
        // Ici la function 'validate' vérifie la validité du formulaire

        request()->validate([
            'first_name'    => 'required|min:3|max:25',
            'last_name'     => 'required|min:3|max:25',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|between:9, 20'
        ]);

        // lorsque le formulaire est validé alors on instancie 'new user'
        $user = new User;
        
        // méthode d'écriture avec le helper 
        $user->first_name   =   request('first_name');
        $user->last_name    =   request('last_name');
        $user->email        =   request('email');
        $user->password     =   bcrypt(request('password'));
        //

        $user->save();

        $success = "Votre inscription est validée!";
        return back()->withSuccess($success);
    }
}
