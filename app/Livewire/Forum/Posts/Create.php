<?php

namespace App\Livewire\Forum\Posts;

use App\Livewire\Forms\PostForm;
use App\Models\Forum\Post;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    public PostForm $post_form;

    public function mount(Post $post): void
    {
        $this->post_form->setPost($post);
    }

    public function render(): View
    {
        return view('livewire.forum.posts.create');
    }

    public function create(): void
    {
        $this->authorize('create', $this->post_form->post);
        $this->post_form->store();
        $this->reset();
        $this->dispatch('post-saved');
        session()->flash('status', 'Post successfully created.');
        $this->redirect('/forum/posts', navigate: true);
    }

    public function update(): void
    {
        $this->authorize('update', $this->post_form->post);
        $this->post_form->update();
        $this->dispatch('post-updated');
        session()->flash('status', 'Post successfully updated.');
        $this->redirect('/forum/posts', navigate: true);
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->post_form->post);
        $this->post_form->delete();
        $this->dispatch('post-deleted');
        session()->flash('status', 'Post successfully deleted.');
        $this->redirect('/forum/posts', navigate: true);
    }
}
