<?php

namespace App\Livewire\Forum\Comments;

use App\Livewire\Forms\CommentForm;
use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public CommentForm $comment_form;

    public Post $post;

    public function mount(Comment $comment): void
    {
        $this->comment_form->setComment($comment);
        $this->post = $this->returnPost($comment->post_id);
    }

    public function render(): View
    {
        return view('livewire.forum.comments.create');
    }

    public function returnPost($post_id): Post
    {
        return Post::find($post_id);
    }

    public function create(): void
    {
        $this->authorize('create', $this->comment_form->comment);
        $this->comment_form->store();
        $this->dispatch('comment-saved');
        // toggle the comment box back to off
        $this->dispatch('comment-hide-form');
    }

    public function update(): void
    {
        $this->authorize('update', $this->comment_form->comment);
        $this->comment_form->update();
        $this->dispatch('comment-updated');
        $this->redirect(route('forum.posts.show', ['post' => $this->comment_form->comment->post]), navigate: true);
    }
}
