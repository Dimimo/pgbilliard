<?php

namespace App\Livewire\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\Visit;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
        if (\Illuminate\Support\Facades\Auth::check()) {
            Visit::query()->updateOrCreate(['post_id' => $post->id, 'user_id' => \Illuminate\Support\Facades\Auth::id()], ['updated_at' => now()]);
        }
    }

    public function render(): View
    {
        return view('livewire.forum.post.show');
    }
}
