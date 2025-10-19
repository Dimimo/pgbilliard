<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;

class DateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'season_id' => ['required', 'exists:seasons,id'],
            'date' => ['required', 'date'],
            'regular' => ['boolean'],
            'title' => [
                'nullable',
                'string',
                'max:20',
            ],
            'remark' => ['nullable', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.date' => 'The date has an incorrect format',
            'title.string' => 'Only string values allowed',
            'title.max' => 'Max '.Constants::DATE_TITLE.' chars',
        ];
    }
}
