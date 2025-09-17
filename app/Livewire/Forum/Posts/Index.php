<?php

namespace App\Livewire\Forum\Posts;

use App\Models\Forum\Post;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.forum.posts.index', [
            'posts' => $this->getPosts(),
        ]);
    }

    public function getPosts(): LengthAwarePaginator
    {
        return Post::with(['user', 'tags', 'visits' => fn ($q) => $q->where('user_id', Auth::id())])
            ->orderByDesc('is_sticky')
            ->orderByDesc('updated_at')
            ->withCount('comments')
            ->paginate(10);
    }

    public function toggle_sticky($id): void
    {
        $post = Post::query()->find($id);
        $post->withoutTimestamps(fn () => $post->update(['is_sticky' => ! $post->is_sticky]));
    }

    public function toggle_locked($id): void
    {
        $post = Post::query()->find($id);
        $post->withoutTimestamps(fn () => $post->update(['is_locked' => ! $post->is_locked]));
    }

    public function delete($id): void
    {
        $post = Post::query()->find($id);
        $this->authorize('delete', $post);
        $post->comments()->delete();
        $post->tags()->detach();
        $post->visits()->delete();
        $post->delete();
        session()->flash('status', 'Post successfully deleted.');
        $this->redirect(route('forum.posts.index'), navigate: true);
    }
}
