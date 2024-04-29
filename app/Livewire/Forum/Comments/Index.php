<?php

namespace App\Livewire\Forum\Comments;

use App\Models\Forum\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{
    public Collection $comments;

    public function mount(Post $post): void
    {
        $this->comments = $post->comments()->select(['body', 'user_id', 'created_at'])->orderByDesc('created_at')->get();
    }

    public function render(): View
    {
        return view('livewire.forum.comments.index');
    }
}
