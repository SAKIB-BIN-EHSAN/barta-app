<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
                'max:130'
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:120'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user()->id
            ],
            'bio' => [
                'nullable',
                'string',
                'max:4294967295'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:16'
            ]
        ];
    }
}
