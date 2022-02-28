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
     * Affiche la liste complètes des annonces dans l'ordre chronologique croissant
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
     * On fait appel à la méthode 'formRequest' pour controle des champs à valider
     * une fois l'annonce créee on est redirigé avec la fonction show
     * pour afficher un message de succes et la nouvelle annonce
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


    

    /**
     * Affiche une seule annonce, après modification ou creation 
     * également appelée si l'utilisateur a cliqué sur la référence de l'annonce
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
    * seul un utilisateur authentifié peut éditer avant modification une annonce
    * et doi t en être le créateur! on vérifie cela avec 'abort_if' si c'est bien le cas
    * si ce n'est pas le cas une page erreur 403 est générée

    * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Annonce $annonce)
    {

        abort_if(auth()->id() != $annonce->user_id, 403);

        $data = [
            'title'=> $description = 'Mise à jour de '.$annonce->reference_annonce,
            'description'=>$description,
            'annonce'=>$annonce,
        ];
        return view('annonce.edit', $data);   
    }

    /**
     * On se sert de 'AnnonceRequest' et sa fonction 'Rule' pour valider le formulaire de modification de l'annonce
     * ATTENTION 
     * Si le propriétaire de l'annonce modifie la référence de son annonce,
     * alors les modifications sont acceptées malgré le paramètre "unique" 
     * demandé lors de la création d'une annonce et son champ "reference_annonce" 
     * 
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
     * Suppression d'un eannonce si l'utilisateur est connecté et en est le propriétaire
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

    //****************************************************************************************************** */

    /**
     * Ci-dessous j'ai utilisé et testé plusieurs méthode en fonction de ma formation
     */

    // Méthode 3 / Dans Models annonce.php, protected $guarded = ['user_id'];
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

    // ***************************************************************************************

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

    // ***************************************************************************************

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


}
