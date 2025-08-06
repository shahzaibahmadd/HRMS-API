<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('Admin') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user->id ?? $this->route('user');

        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $userId,
            'phone'         => 'nullable|string|unique:users,phone,' . $userId,
            'is_active'     => 'nullable|boolean',
            'role'          => 'nullable|string|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'      => 'nullable|string|min:6',
            'skills'        => 'nullable|string|max:500',
            'documents'     => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:5120',
            'resume'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'contract'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
