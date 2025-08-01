<?php

namespace App\Http\Requests\PerformanceReview;

use Illuminate\Foundation\Http\FormRequest;

class PerformanceReviewRequest extends FormRequest
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
            'user_id'     => 'required|exists:users,id',
            'feedback'    => 'nullable|string',
            'review_date' => 'required|date',
        ];
    }
}
