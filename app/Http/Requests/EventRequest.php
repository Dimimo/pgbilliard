<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_id' => ['required', 'exists:dates'],
            'venue_id' => ['required', 'exists:venues'],
            'team1' => ['required', 'exists:teams'],
            'team2' => ['required', 'exists:teams'],
            'score1' => [
                'nullable',
                'integer',
                'between:0, 15',
            ],
            'score2' => [
                'nullable',
                'integer',
                'between:0, 15',
            ],
            'confirmed' => ['boolean'],
            'remark' => ['nullable|max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_id.required' => 'Choose a date',
            'date_id.exists' => "This date doesn't exist",
            'venue_id.required' => 'Choose a venue',
            'venue_id.exists' => "This venue doesn't exist",
            'team1.required' => 'Choose the home team',
            'team1.exists' => 'This team does not exist',
            'team2.required' => 'Choose the home team',
            'team2.exists' => 'This team does not exist',
            'score1.integer' => 'The score is not numeric',
            'score1.between' => 'The score is not between 0 and 15',
            'score2.integer' => 'The score is not numeric',
            'score2.between' => 'The score is not between 0 and 15',
        ];
    }
}
