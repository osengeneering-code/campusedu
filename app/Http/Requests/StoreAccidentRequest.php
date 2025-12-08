<?php

namespace App\Http\Requests;

use App\Enums\AccidentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreAccidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // For now, allow all authenticated users. Policy will handle fine-grained access.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'police_officer_name' => 'nullable|string|max:255',
            'status' => ['required', new Enum(AccidentStatusEnum::class)],
            'report_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // 2MB Max
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max per photo
        ];
    }
}
