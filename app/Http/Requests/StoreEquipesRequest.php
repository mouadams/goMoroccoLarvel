<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255|unique:equipes,nom',
            'drapeau' => 'required|url|max:500',
            'groupe' => 'required|string|size:1|in:A,B,C,D,E,F', // changed max:1 to size:1
            'abreviation' => 'required|string|size:3|unique:equipes,abreviation', // changed max:3 to size:3
            'confederation' => 'required|string|max:100',
            'entraineur' => 'nullable|string|max:255', // made entraineur nullable
            'rang' => 'required|integer|min:1|max:300',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de l\'équipe est requis',
            'nom.unique' => 'Ce nom d\'équipe existe déjà',
            'drapeau.required' => 'Le drapeau est requis',
            'groupe.required' => 'Le groupe est requis',
            'abreviation.required' => 'L\'abréviation est requise',
            'abreviation.unique' => 'Cette abréviation existe déjà',
            'confederation.required' => 'La confédération est requise',
            'entraineur.required' => 'Le nom de l\'entraineur est requis',
            'rang.required' => 'Le rang est requis',
            'rang.integer' => 'Le rang doit être un nombre entier',
            'rang.min' => 'Le rang minimum est 1',
        ];
    }
}
