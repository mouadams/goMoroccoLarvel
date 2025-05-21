<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
            'cuisine' => 'required|string|max:255',
            'description' => 'required|string',
            'adresse' => 'required|string|max:255',
            'note' => 'required|numeric|min:1|max:5',
            'distance' => 'required|string|max:100',
            'prixMoyen' => 'required|string|max:100',
            'horaires' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stadeId' => 'required|integer|exists:stades,id'
        ];
    
    }
}
