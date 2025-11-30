<?php

namespace App\Http\Requests;

use App\Constants;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'min:2',
                'max:'.Constants::USERCHARS,
                'unique:'.User::class.',name',
            ],
            'email' => [
                'required',
                'email',
                'max:254',
                'unique:'.User::class.',email',
            ],
            'contact_nr' => ['nullable', 'max:'.Constants::PHONECHARS],
            'gender' => ['nullable', 'string'],
            'last_game' => ['nullable', 'date'],
            'email_verified_at' => ['nullable', 'date'],
            'password' => ['sometimes'],
        ];
    }

    #[\Override]
    public function messages(): array
    {
        return [
            'name.string' => 'A name needs to be string',
            'name.min' => 'A name needs at least 2 characters',
            'name.max' => 'A name can not be longer than '.Constants::USERCHARS.' characters',
            'name.unique' => 'This name is already taken',
            'email.required' => 'A valid email address is required',
            'email.email' => 'A valid email address is required',
            'email.unique' => 'The email has to be unique',
        ];
    }
}
