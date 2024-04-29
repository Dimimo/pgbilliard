<?php

namespace App\Livewire\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\Visit;
use Auth;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
        Auth::check() ?? Visit::updateOrCreate(['post_id' => $post->id, 'user_id' => Auth::id()]);
    }

    public function render(): View
    {
        return view('livewire.forum.post.show');
    }
}
