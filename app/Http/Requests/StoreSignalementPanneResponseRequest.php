<?php

namespace App\Http\Requests;

use App\Enums\SignalementResponseStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSignalementPanneResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Policy will handle fine-grained access.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'signalement_panne_id' => 'required|exists:signalement_pannes,id',
            'user_id' => 'nullable|exists:users,id', // Set in controller
            'date_reponse' => 'nullable|date', // Set in controller
            'description' => 'required|string',
            'status_update' => ['required', new Enum(SignalementResponseStatusEnum::class)],
            'cost_estimation' => 'nullable|numeric|min:0',
            'intervention_date' => 'nullable|date',
        ];
    }
}
