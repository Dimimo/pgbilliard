<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Forum\Post;
use Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public Post $post;

    #[Validate([
        'required',
        'min:2',
        'max:'.Constants::FORUM_TITLE,
    ], message: [
        'title.required' => 'A title is required',
        'title.min' => 'A title must have a minimum of 2 chars',
        'title.max' => 'A title can\'t have more than '.Constants::FORUM_TITLE.' chars',
    ])]
    public string $title;

    #[Validate([
        'required',
        'min:2',
        'max:'.Constants::FORUM_BODY,
    ], message: [
        'message.required' => 'A message is required',
        'message.min' => 'A message must have a minimum of 2 chars',
        'message.max' => 'A message can\'t have more than '.Constants::FORUM_BODY.' chars',
    ])]
    public string $body;

    #[Validate('boolean')]
    public bool $is_locked = false;

    #[Validate('boolean')]
    public bool $is_sticky = false;

    public function setPost(Post $post): void
    {
        $this->post = $post;
        $this->title = $post->title ?: '';
        $this->body = $post->body ?: '';
        $this->is_locked = $post->is_locked ?: false;
        $this->is_sticky = $post->is_sticky ?: false;
    }

    public function store(): void
    {
        $values = $this->validate();
        $this->post = Post::create(array_merge($values, ['slug' => Str::slug($values['title']), 'user_id' => Auth::id()]));
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
