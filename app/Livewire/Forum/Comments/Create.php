<?php

namespace App\Livewire\Forum\Comments;

use App\Livewire\Forms\CommentForm;
use App\Models\Forum\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public CommentForm $comment_form;

    public function mount(Comment $comment): void
    {
        $this->comment_form->setComment($comment);
    }

    public function render(): View
    {
        return view('livewire.forum.comments.create');
    }

    public function create(): void
    {
        $this->authorize('create', $this->comment_form->comment);
        $this->comment_form->store();
        $this->dispatch('comment-created');
    }

    public function update(): void
    {
        $this->authorize('update', $this->comment_form->comment);
        $this->comment_form->update();
        $this->dispatch('comment-updated');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->comment_form->comment);
        $this->comment_form->delete();
        $this->dispatch('comment-deleted');
    }
}
