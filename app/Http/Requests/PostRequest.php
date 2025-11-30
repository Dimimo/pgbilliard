<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:2',
                'max:'.Constants::FORUM_TITLE,
            ],
            'slug' => ['required', 'string'],
            'body' => [
                'required',
                'min:2',
                'max:'.Constants::FORUM_BODY,
            ],
            'user_id' => ['required', 'exists:users,id'],
            'is_locked' => ['boolean'],
            'is_sticky' => ['boolean'],
        ];
    }

    #[\Override]
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.min' => 'A title must have a minimum of 2 chars',
            'title.max' => 'A title can\'t have more than '.Constants::FORUM_TITLE.' chars',
            'message.required' => 'A message is required',
            'message.min' => 'A message must have a minimum of 2 chars',
            'message.max' => 'A message can\'t have more than '.Constants::FORUM_BODY.' chars',
        ];
    }
}
