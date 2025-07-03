<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'type' => 'required|in:simple,variable',
            'price' => 'nullable|numeric',
            'variations' => 'array',
            'variations.*.name' => 'required|string',
            'variations.*.options' => 'array',
            'variations.*.options.*.name' => 'required|string',
            'variations.*.options.*.price' => 'nullable|numeric'
        ];
    }
}
