<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;  

class UpdateEquipesRequest extends FormRequest
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
        // Get the ID from the route parameter
        $equipeId = $this->route('id') ?? $this->route('equipe');
        
        return [
            'nom' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('equipes')->ignore($equipeId)
            ],
            'drapeau' => 'sometimes|url|max:500|starts_with:https://',
            'groupe' => 'sometimes|string|size:1|in:A,B,C,D,E,F',
            'abreviation' => [
                'sometimes',
                'string',
                'size:3',
                'alpha',
                Rule::unique('equipes')->ignore($equipeId)
            ],
            'confederation' => 'sometimes|string|max:100',
            'entraineur' => 'sometimes|string|max:255|nullable',
            'rang' => 'sometimes|integer|min:1|max:300',
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
            'nom.string' => 'Le nom de l\'équipe doit être une chaîne de caractères',
            'nom.unique' => 'Ce nom d\'équipe existe déjà',
            'abreviation.unique' => 'Cette abréviation existe déjà',
            'rang.integer' => 'Le rang doit être un nombre entier',
            'rang.min' => 'Le rang minimum est 1',
        ];
    }
}
