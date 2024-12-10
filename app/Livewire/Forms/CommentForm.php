<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Forum\Comment;
use Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CommentForm extends Form
{
    public Comment $comment;

    #[Validate([
        'required',
        'min:1',
        'max:'.Constants::COMMENT_BODY,
    ], message: [
        'body.required' => 'You can not leave an empty comment',
        'body.min' => 'A comment needs to be at least 1 character long',
        'body.max' => 'A comment can not have more than '.Constants::COMMENT_BODY.' characters',
    ])]
    public string $body;

    #[Validate(['required', 'integer', 'exists:posts,id'])]
    public int $post_id;

    #[Validate(['required', 'integer', 'exists:users,id'])]
    public int $user_id;

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
        $this->body = $this->comment->body ?: '';
        $this->post_id = $this->comment->post_id;
        $this->user_id = $this->comment->user_id ?: Auth::id();
    }

    public function store(): void
    {
        $validated = $this->validate();
        $this->comment = $this->comment->create($validated);
        $this->comment->post()->touch();
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->comment->update($validated);
    }

    public function delete(): void
    {
        $this->comment->delete();
    }
}
