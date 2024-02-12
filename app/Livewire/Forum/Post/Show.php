<?php

namespace App\Livewire\Forum\Post;

use App\Models\Forum\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render(): View
    {
        return view('livewire.forum.post.show');
    }
}
