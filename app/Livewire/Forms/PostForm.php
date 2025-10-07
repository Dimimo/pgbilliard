<?php

namespace App\Livewire\Forms;

use App\Http\Requests\PostRequest;
use App\Models\Forum\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public Post $post;

    #[Validate]
    public string $title = '';

    #[Validate]
    public string $body = '';

    #[Validate]
    public bool $is_locked = false;

    #[Validate]
    public bool $is_sticky = false;

    public function rules(): array
    {
        return (new PostRequest())->rules();
    }

    public function messages(): array
    {
        return (new PostRequest())->messages();
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
        $this->fill($this->post);
    }

    public function store(): void
    {
        $values = $this->validate();
        $this->post = auth()->user()->posts()->create($values);
    }

    public function update(): void
    {
        $this->post->update($this->validate());
        $this->post->refresh();
    }

    public function delete(): void
    {
        $this->post->comments()->delete();
        $this->post->tags()->detach();
        $this->post->visits()->delete();
        $this->post->delete();
    }
}
