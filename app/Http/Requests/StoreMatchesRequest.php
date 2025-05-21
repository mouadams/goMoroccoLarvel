<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
            return [
                'stadeId' => 'required|integer|exists:stades,id',
                'equipe1' => 'required|integer',
                'equipe2' => 'required|integer',
                'date' => 'required|date',
                'heure' => 'required|string',
                'phase' => 'required|string|max:255',
                'groupe' => 'nullable|string|max:255',
                'score1' => 'nullable|integer|min:0',
                'score2' => 'nullable|integer|min:0',
                'termine' => 'boolean',
            ];
    }
}
