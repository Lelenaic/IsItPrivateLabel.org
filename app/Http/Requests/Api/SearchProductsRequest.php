<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SearchProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            /**
             * Search term (min 2 characters). Matches product names, serial numbers, and company names.
             *
             * @example "organic milk"
             */
            'q' => ['sometimes', 'string'],
            /**
             * Number of results per page.
             *
             * @default 20
             *
             * @example 50
             */
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            /**
             * Page number to retrieve.
             *
             * @default 1
             */
            'page' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
