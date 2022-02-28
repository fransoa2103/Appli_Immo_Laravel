<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Annonce;

class AnnonceController extends Controller
{
    protected $articlePerPage = 3;
    
    public function __construct()
    {
        /*
        *   on utilise le middleware 'auth' => App\Http\Middleware\Authenticatye.php,
        *   pour filtrer l'accès des utilisateurs à la bdd.
        *   En effet seul un membre connecté pourra créer, modifier ou supprimer un article.
        *   ici en paramètre, on spécifie avec 'except' que seules les méthodes 'index' et 'show'
        *   sont accessibles sans que auth = true, cad sans connexion utilisateur.
        */
        $this->middleware('auth')->except('index','show');        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Annonces = Annonce::orderByDesc('id')->paginate($this->articlePerPage);

        $data = [
            'title'=>'Liste des Annonces - '.config('app.name'),
            'description'=>'Retrouvez ici tous les Annonces '.config('app.name'),
            'Annonces'=>$Annonces
        ];
        return view('annonce.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        
        $data = [
            'reference_annonce'=>$annonce->reference_annonce.' - '.config('app.name'),
            'description_annonce'=>$annonce->reference_annonce.'. '.Str::words($annonce->description_annonce, 10),
            'annonce'=>$annonce
        ];
        return view('annonce.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return "je suis article # ".$id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
