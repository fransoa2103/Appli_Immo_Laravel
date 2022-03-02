<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnonceRequest extends FormRequest
{
    /**
     * Determine si un utilisateur authentifié a le droit d'utiliser le formulaire de création d'une nouvelle annonce.
     * 
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation du formulaire de création et modification d'une annonce
     * lors de la création en méthod POST la reference_annonce se devra etre unique
     * mais lors de sa modification en méthod PUT/update alors la reference_annonce peut etre conservée (ce qui est le but)
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reference_annonce'     => $this->method() == 'POST' ?
            ['required', 'max:10', 'unique:annonces,reference_annonce'] :
            ['required', 'max:10', Rule::unique('annonces','reference_annonce')->ignore($this->annonce)],
            'description_annonce'   => ['required'],
            'prix_annonce'          => ['required', 'digits_between:1,12'],
            'surface_habitable'     => ['required', 'digits_between:1,6'],
            'nombre_de_piece'       => ['required', 'digits_between:1,2']
        ];
    }
}
