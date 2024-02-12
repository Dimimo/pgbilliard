<?php

namespace App\Livewire\Forum\Posts;

use App\Models\Forum\Post;
use Auth;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

/**
 * @property Form $form
 */
class Create extends Component implements HasForms
{
    use InteractsWithForms;

    public ?string $title;

    public ?string $body;

    public bool $is_locked = false;

    public bool $is_sticky = false;

    public function mount(): void
    {
        $post = new Post(['title' => '', 'body' => '', 'is_locked' => false, 'is_sticky' => false]);
        $this->form->fill($post->toArray());
    }

    public function form(Form $form): Form
    {
        $schema = [
            Forms\Components\TextInput::make('title')->rules(['required', 'max:80'])->validationMessages(
                ['required' => 'A post needs a :attribute']
            )->label('Title of your post'),
            Forms\Components\RichEditor::make('body')->rules(['required', 'max:1000'])->validationMessages(
                ['required' => 'A post needs a message']
            )->label('What is the post about?'),
        ];
        if (Auth::user()->isAdmin()) {
            $schema = array_merge($schema, [
                Forms\Components\Toggle::make('is_locked')->required()->default(false),
                Forms\Components\Toggle::make('is_sticky')->required()->default(false),
            ]);
        }

        return $form->schema($schema)->model(Post::class);
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::id();
        $record = Post::create($data);
        $this->form->model($record)->saveRelationships();
        $this->form->fill();
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
        $this->dispatch('post-saved');
        //Todo: enter a redirect to the index
    }

    public function render(): View
    {
        return view('livewire.forum.posts.create');
    }
}
