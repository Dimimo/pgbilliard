<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Forum\Post;
use Auth;
use Illuminate\Support\Str;
use Livewire\Form;

class PostForm extends Form
{
    public Post $post;

    public string $title;

    public string $body;

    public bool $is_locked = false;

    public bool $is_sticky = false;

    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:'.Constants::FORUM_TITLE,
            'body' => 'required|min:2|max:'.Constants::FORUM_BODY,
            'is_locked' => 'nullable|boolean',
            'is_sticky' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required',
            'title.min' => 'A title must have a minimum of 2 chars',
            'title.max' => 'A title can not have more than '.Constants::FORUM_TITLE.' chars',
            'body.required' => 'A message is required',
            'body.min' => 'A message must have a minimum of 2 chars',
            'body.max' => 'A message can not have more than '.Constants::FORUM_TITLE.' chars',
        ];
    }

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
