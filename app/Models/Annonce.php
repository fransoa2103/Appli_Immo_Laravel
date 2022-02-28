<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    
    // Protection des champs lors de la création d'un article
    // ex: si un champ 'active_user' ou 'admin_user' existe, on ne veut pas qu'un utilisateur lambda puisse y acceder
    
    // MASS ASSIGNEMENT FILLABLE   
    // $fillable on y spécifie les champs que l'on souhaite créer et insérer automatiquement à la validation
    // protected $fillable = ['user_id', 'reference_annonce', 'description_annonce', 'prix_annonce', 'surface_habitable', 'nombre_de_piece'];
    
    // MASS ASSIGNEMENT GUARDED
    // $guarded on y spécifie les champs qui vont être créer automatiquement,
    // et donc par défaut le tableau vide spécifie que tous les champs sont crées ce qui equivaut à $fillable=['tous les champs'].
    // ici user_id n'est pas renseigné par l'utilisateur lors de la saisie du formaulaire nouvelle annonce
    // user_id est automatiquement récupéré dans Auth
    
    protected $guarded  = ['user_id'];
    
    /**
    * Relation belongsTo entre les champs annonces/'user_id' et users/'id'
    * une annonce n'appartient qu' à un seul agent immobilier
    */

    public function user()
    {
        return$this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'reference_annonce';
    }
}
