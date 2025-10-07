<?php

namespace App\Http\Requests;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => [
                'required',
                'min:1',
                'max:'.Constants::COMMENT_BODY,
            ],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'You can not leave an empty comment',
            'body.min' => 'A comment needs to be at least 1 character long',
            'body.max' => 'A comment can not have more than '.Constants::COMMENT_BODY.' characters',
        ];
    }
}
