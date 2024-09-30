<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlacementRequest extends FormRequest
{
    public function authorize(): true
    {
        // Authorize all users to make this request.
        return true;
    }

    public function rules(): array
    {
        return [
            'sort_by' => 'nullable|string|in:key,platform,total,invalid_total,invalid_total_percent,pixel_stuffing,pixel_stuffing_percent,viewable,viewable_percent,non_viewable,non_viewable_percent,mfa_site_symptoms,mfa_site_symptoms_percent,other_invalid,other_invalid_percent',
            'sort_order' => 'nullable|string|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
            'paginate' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'sort_by.in' => 'The selected sort_by field is invalid.',
            'sort_order.in' => 'The sort_order must be either asc or desc.',
            'per_page.integer' => 'The per_page must be an integer.',
            'per_page.min' => 'The per_page must be at least 1.',
            'per_page.max' => 'The per_page may not be greater than 100.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
            'paginate.boolean' => 'The paginate field must be true or false.',
        ];
    }
}
