<?php

namespace App\Http\Requests;

use App\Constants;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VenueRequest extends FormRequest
{
    public function rules(Venue $venue, ?int $user_id = null): array
    {
        // $venue = Venue::find($venue_id);
        return [
            'name' => [
                'required',
                'min:2',
                'max:'.Constants::VENUECHARS,
                Rule::unique(Venue::class)->ignore($venue),
            ],
            'user_id' => [
                'sometimes',
                'nullable',
                Rule::exists(User::class, 'id'),
                // 'exists:'.User::class.',id',
            ],
            'address' => [
                'required',
                'string',
                'max:120',
            ],
            'contact_name' => [
                'nullable',
                'string',
                'max:'.Constants::USERCHARS,
            ],
            'contact_nr' => [
                'nullable',
                'string',
                'max:'.Constants::PHONECHARS,
            ],
            'remark' => [
                'nullable',
                'string',
                'max:255',
            ],
            'lat' => [
                'nullable',
                'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
            ],
            'lng' => [
                'nullable',
                'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The venue needs a name',
            'name.min' => 'The name of a venue needs to be at least 2 characters long',
            'name.max' => 'The name of a venue can not be longer than '.Constants::VENUECHARS.' characters',
            'name.unique' => 'This name already exists. Needs to be unique.',
            'address.required' => 'Please provide at least some description how to find the venue',
            'address.string' => 'An address has to alphanumerical',
            'address.max' => 'Please limit the address to 120 characters',
            'contact_name.max' => 'The contact name can not be longer than '.Constants::USERCHARS.' characters',
            'contact_nr.max' => 'The contact number can not be longer than '.Constants::PHONECHARS.' characters',
            'lat.regex' => 'Please provide an existing latitude expressed in a decimal number',
            'lng.regex' => 'Please provide an existing latitude expressed in a decimal number',
        ];
    }
}
