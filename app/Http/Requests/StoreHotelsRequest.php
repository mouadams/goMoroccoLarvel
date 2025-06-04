<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelsRequest extends FormRequest
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
            'description' => 'required|string',
            'etoiles' => 'required|integer|min:1|max:5',
            'ville' => 'required|string|max:255', // Make sure this is present and correct
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // For create, this should be required
            'prix' => 'required|string|max:100',
            'distance' => 'required|string|max:100',
            'adresse' => 'required|string|max:255', // Assuming max 255
            'phone' => 'required|string|regex:/^[0-9]{8,15}$/', // Matching frontend regex
            'wifi' => 'boolean', // Assuming it's a boolean (0 or 1)
            'parking' => 'boolean', // Make sure this is present
            'piscine' => 'boolean', // Assuming it's a boolean (0 or 1)
            'stadeId' => 'required|integer|min:1', // Assuming min 1
        ];
    }
}
