<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStadesRequest extends FormRequest
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
        $stadeId = $this->route('stades') ? $this->route('stades')->id : null;

        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stades')->ignore($stadeId)
            ],
            'ville' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'annee_construction' => [
                'required',
                'integer',
                'min:1800',
                'max:'.(date('Y')+1)
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du stade est obligatoire',
            'nom.unique' => 'Ce nom de stade est déjà utilisé',
            'ville.required' => 'La ville est obligatoire',
            'capacite.required' => 'La capacité est obligatoire',
            'capacite.min' => 'La capacité doit être au moins 1',
            'image.image' => 'Le fichier doit être une image valide',
            'image.mimes' => 'Seuls les formats JPEG, PNG et JPG sont acceptés',
            'image.max' => "L'image ne doit pas dépasser 2MB",
            'latitude.required' => 'La latitude est obligatoire',
            'longitude.required' => 'La longitude est obligatoire',
            'annee_construction.required' => "L'année de construction est obligatoire",
        ];
    }

}
