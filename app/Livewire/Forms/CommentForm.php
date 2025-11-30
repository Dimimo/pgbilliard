<?php

namespace App\Livewire\Forms;

use App\Http\Requests\CommentRequest;
use App\Models\Forum\Comment;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CommentForm extends Form
{
    public Comment $comment;

    #[Validate]
    public string $body;

    #[Validate]
    public int $post_id;

    #[Validate]
    public int $user_id;

    public function rules(): array
    {
        return (new CommentRequest())->rules();
    }

    public function messages(): array
    {
        return (new CommentRequest())->messages();
    }

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
        $this->body = $this->comment->body ?: '';
        $this->post_id = $this->comment->post_id;
        $this->user_id = $this->comment->user_id ?: \Illuminate\Support\Facades\Auth::id();
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
