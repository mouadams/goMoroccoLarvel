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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'prix' => 'required|string|max:100',
            'distance' => 'required|string|max:100',
            'adresse' => 'required|string|max:100',
            'phone' => 'required|string|regex:/^[0-9]{8,15}$/', 
            'wifi' => 'nullable|boolean',
            'piscine' => 'nullable|boolean',
            'stadeId' => 'required|integer|exists:stades,id',
        ];
    }
}
