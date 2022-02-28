<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Annonce;
use App\Http\Requests\AnnonceRequest;

class AnnonceController extends Controller
{
    protected $annoncePerPage = 3;
    
    /*
    *   on utilise le middleware 'auth' => App\Http\Middleware\Authenticate.php,
    *   pour filtrer l'accès des utilisateurs à la bdd.
    *   En effet seul un membre connecté pourra créer, modifier ou supprimer un annonce.
    *   ici en paramètre, on spécifie avec 'except' que seules les méthodes 'index' et 'show'
    *   sont accessibles sans que auth soit = a 'true', cad sans connexion utilisateur.
    */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Annonces = Annonce::orderByDesc('id')->paginate($this->annoncePerPage);

        $data = [
            'title'=>'Liste des Annonces - '.config('app.name'),
            'description'=>'Retrouvez ici tous les Annonces '.config('app.name'),
            'Annonces'=>$Annonces
        ];
        return view('annonce.index', $data);
    }

    /**
     * Appel le formulaire de création d'une nouvelle Annonce.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'         => $description = 'Ajouter un nouvel annonce',
            'description'   => $description
        ];
        return view('annonce.create', $data);
    }


    /**
     * enregistre les données du formulaire nouvelle annonce.
     * On fait appel à la méthode 'formRequest' créee, ici c'est AnnonceRequest
     * Les données du formulaire de création d'un nouvelle annonce sont envoyées pour controle
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // Méthode 4 / avec FormRequest
    public function store(AnnonceRequest $request)
    {
        $validateData = $request->validated();
        $annonce = Auth::user()->annonces()->create($validateData);
        $success = 'annonce ajouté';
        return redirect()->route('annonces.show', ['annonce'=>$annonce->reference_annonce])->withSuccess($success);
    }

    // // Méthode 3 / Dans Models annonce.php, protected $guarded = ['user_id'];
    // public function store(Request $request)
    // {
    //     $annonce = Auth::user()->annonces()->create(request()->validate([
    //         'reference_annonce'     => ['required', 'max:10', 'unique:annonces,reference_annonce'],
    //         'description_annonce'   => ['required'],
    //         'prix_annonce'          => ['required', 'digits_between:2,9'],
    //         'surface_habitable'     => ['required', 'digits_between:2,5'],
    //         'nombre_de_piece'       => ['required', 'digits_between:1,2']
    //     ]));

    //     $success = 'annonce ajouté';
    //     return back()->withSuccess($success);
    // }

    // Methode 2/ on valide et insère en même temps
    // public function store(Request $request)
    // {
    //     request()->validate([
    //         'reference_annonce'     => ['required', 'max:10', 'unique:annonces,reference_annonce'],
    //         'description_annonce'   => ['required'],
    //         'prix_annonce'          => ['required', 'digits_between:2,9'],
    //         'surface_habitable'     => ['required', 'digits_between:2,5'],
    //         'nombre_de_piece'       => ['required', 'digits_between:1,2']
    //     ]);
    //     $annonce = Annonce::create([
    //         'user_id'             => auth()->id(),
    //         'reference_annonce'   => request('reference_annonce'),
    //         'description_annonce' => request('description_annonce'),
    //         'prix_annonce'        => request('prix_annonce'),
    //         'surface_habitable'   => request('surface_habitable'),
    //         'nombre_de_piece'     => request('nombre_de_piece')
    //     ]);

    //     $success = 'annonce ajouté';
    //     return back()->withSuccess($success);
    // }

    // Methode classique de store avec validate 
    // on valide, puis on instancie puis on créee (save)
    // public function store(Request $request)
    // {
    //     request()->validate([
    //         'reference_annonce'     => ['required', 'max:10', 'unique:annonces,reference_annonce'],
    //         'description_annonce'   => ['required'],
    //         'prix_annonce'          => ['required', 'digits_between:2,9'],
    //         'surface_habitable'     => ['required', 'digits_between:2,5'],
    //         'nombre_de_piece'       => ['required', 'digits_between:1,2']
    //     ]);

    //     $annonce = new Annonce;
    //     $annonce->user_id               = auth()->id();
    //     $annonce->reference_annonce     = request('reference_annonce');
    //     $annonce->description_annonce   = request('description_annonce');
    //     $annonce->prix_annonce          = request('prix_annonce');
    //     $annonce->surface_habitable     = request('surface_habitable');
    //     $annonce->nombre_de_piece       = request('nombre_de_piece');
        
    //     $annonce->save();
        
    //     $success = 'annonce ajouté';
    //     return back()->withSuccess($success);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Annonce $annonce)
    {
        $data = [
            'title'=>config('app.name'),
            'description'=>$annonce->reference_annonce,
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
    public function edit(Annonce $annonce)
    {
        // seul un user authentifié peut éditer une annonce
        // mais en plus il doit en être le créateur!
        // donc on vérifie avec abort_if si c'est bien le cas
        // si ce n'est pas le cas une page erreur 403 est générée

        abort_if(auth()->id() != $annonce->user_id, 403);

        $data = [
            'title'=> $description = 'Mise à jour de '.$annonce->reference_annonce,
            'description'=>$description,
            'annonce'=>$annonce,
        ];
        return view('annonce.edit', $data);   
    }

    /**
     * On se sert de la class 'AnnonceRequest' et sa fonction 'Rule' pour valider le formaulaire de modification de l'annonce
     * ATTENTION 
     * Si le propriétaire de l'annonce modifie la référence de son annonce,
     * alors les modifications apportées créeent une nouvelle annonce!
     * l'idée est de garder évidemment la même référence.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnnonceRequest $request, Annonce $annonce)
    {
        abort_if(auth()->id() != $annonce->user_id, 403);
        
        $validateData = $request->validated();
        $annonce = Auth::user()->annonces()->updateOrCreate(['id'=>$annonce->id], $validateData);
        
        $success = 'Annonce modifiée';
        // Au cas ou la référence ait été modifiée, on redirige vers la page avec la "bonne" référence
        return redirect()->route('annonces.show', ['annonce'=>$annonce->reference_annonce])->withSuccess($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annonce $annonce)
    {
        abort_if(auth()->id() != $annonce->user_id, 403);
        
        $annonce->delete();

        $success = 'Votre annonce a bien été supprimée !';
        return back()->withSuccess($success);
    }
}
