<?php

namespace App\Livewire\Forum\Posts;

use App\Models\Forum\Post;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query()->orderByDesc('updated_at'))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Post $record): string => route('forum.post.show', ['Post' => $record])),
                Tables\Columns\TextColumn::make('body')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\CheckboxColumn::make('is_locked'),
                Tables\Columns\CheckboxColumn::make('is_sticky'),
                Tables\Columns\TextColumn::make('comments_count')
                    ->counts('comments')
                    ->sortable()
                    ->label('#'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M j, Y H:i')
                    ->sortable('desc')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Once a post is created, it will appear here.')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create post')
                    ->url('forum/posts/create')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.forum.posts.index');
    }
}
