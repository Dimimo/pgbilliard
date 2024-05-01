<?php

namespace App\Livewire\Forum\Comments;

use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Collection $comments;

    public Post $post;

    public bool $showComment;

    public function mount(Post $post): void
    {
        $this->post = $post;
        $this->getComments();
        $this->showComment = false;
    }

    public function render(): View
    {
        return view('livewire.forum.comments.index');
    }

    private function getComments(): void
    {
        $this->comments = $this->post->comments()->orderBy('created_at')->get();
    }

    public function toggleComment(): void
    {
        $this->showComment = ! $this->showComment;
    }

    #[On('comment-hide-form')]
    public function commentHideForm(): void
    {
        $this->showComment = ! $this->showComment;
        $this->getComments();
    }

    public function delete($id): void
    {
        $comment = Comment::find($id);
        $comment->delete();
        $this->getComments();
    }
}
