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
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'etoiles' => 'required|integer|min:1|max:5',  
            'image' => 'required|string|url',  
            'prix' => 'required|string|max:100',  
            'distance' => 'required|string|max:100',
            'stadeId' => 'required|integer|exists:stades,id'
            
        ];
    }
}
