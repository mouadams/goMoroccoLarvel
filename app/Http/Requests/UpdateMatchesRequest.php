<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchesRequest extends FormRequest
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
            'stadeId' => 'sometimes|integer|exists:stades,id',
            'equipe1' => 'sometimes|integer',
            'equipe2' => 'sometimes|integer',
            'date' => 'sometimes|date',
            'heure' => 'sometimes|string',
            'phase' => 'sometimes|string|max:255',
            'groupe' => 'nullable|string|max:255',
            'score1' => 'nullable|integer|min:0',
            'score2' => 'nullable|integer|min:0',
            'termine' => 'sometimes|boolean',
        ];
;
    }
}
