<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
        // For an update request, almost all fields should be 'sometimes'
        // unless there's a very specific reason they *must* always be present.
        return [
            'nom' => 'sometimes|string|max:255',
            'cuisine' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'adresse' => 'sometimes|string|max:255',
            'note' => 'sometimes|numeric|min:1|max:5',
            'distance' => 'sometimes|string|max:100',
            'prixMoyen' => 'sometimes|string|max:100',
            'horaires' => 'sometimes|nullable|string|max:255',
            'telephone' => 'sometimes|nullable|string|max:20',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stadeId' => 'sometimes|integer|exists:stades,id'
        ];
    }
}
