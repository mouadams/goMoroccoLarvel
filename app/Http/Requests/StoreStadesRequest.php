<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStadesRequest extends FormRequest
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
            
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            "description" => "required|string|max:500",
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'annee_construction' => 'required|integer|min:1800|max:'.(date('Y')+1)
        ];
    }
}
