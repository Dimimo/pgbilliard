<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Forum\Comment;
use Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class CommentForm extends Form
{
    public Comment $comment;

    #[Rule(['required', 'min:2', 'max:'.Constants::COMMENT_BODY])]
    public string $body;

    #[Rule(['required', 'integer', 'exists:App\Models\Forum\Post,id'])]
    public int $post_id;

    #[Rule(['required', 'integer', 'exists:App\Models\User,id'])]
    public int $user_id;

    public $message = [
        'body.required' => 'You can not leave an empty comment',
        'body.min' => 'A comment needs to be at least 2 characters long',
        'body.max' => 'A comment can not have more than '.Constants::COMMENT_BODY.' characters',
    ];

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
        $this->body = $this->comment->body;
        $this->post_id = $this->comment->post_id;
        $this->user_id = $this->comment->user_id ?: Auth::id();
    }

    public function store(): void
    {
        $validated = $this->validate();
        Comment::create($validated);
    }

    public function update(): void
    {
        $validated = $this->validate();
        Comment::update($validated);
    }

    public function delete(): void
    {
        $this->comment->delete();
    }
}
