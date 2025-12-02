<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIntegrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'credentials' => 'nullable|array',
            'settings' => 'nullable|array',
            'mappings' => 'nullable|array',
            'mappings.*.source_field' => 'required|string',
            'mappings.*.target_field' => 'required|string',
        ];
    }
}
