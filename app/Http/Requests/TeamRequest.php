<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:' . Constants::TEAMCHARS,
            ],
            'venue_id' => [
                'required',
                'exists:App\Models\Venue,id',
            ],
            'season_id' => [
                'required',
                'exists:App\Models\Season,id',
            ],
            'remark' => [
                'nullable', 'text'
            ],
        ];
    }

    #[\Override]
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a team name',
            'name.min' => 'A team name must have at least 2 characters',
            'name.max' => 'A team name can\'t be longer than ' . Constants::TEAMCHARS . ' characters',
            'venue_id.required' => 'A team must have a venue (bar)',
            'venue_id.exists' => 'The selected venue does not exist',
            'season_id.required' => 'Please select a Season',
            'season_id.exists' => 'The selected Season does not exist'
        ];
    }
}
