<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelsRequest extends FormRequest
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
        'nom' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'etoiles' => 'sometimes|integer|min:1|max:5',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'prix' => 'sometimes|string|max:100',
        'distance' => 'sometimes|string|max:100',
        'adresse' => 'sometimes|string|max:100',
        'phone' => 'sometimes|string|regex:/^[0-9]{8,15}$/',
        'wifi' => 'nullable|boolean',
        'piscine' => 'nullable|boolean',
        'stadeId' => 'sometimes|integer|exists:stades,id',
    ];
}
}
