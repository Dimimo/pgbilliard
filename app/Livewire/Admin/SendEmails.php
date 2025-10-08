<?php

namespace App\Livewire\Admin;

use App\Constants;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SendEmails extends Component
{
    public Collection $users;
    protected Collection $teams;

    #[Validate(rule: ['required'], message: ['group.required' => 'Please select an option'])]
    public ?string $group = null;
    public array $choices = ['players', 'captains', 'administrators'];
    #[Validate(
        rule: ['required', 'min:2', 'max:'.Constants::EMAIL_TITLE],
        message: [
            'title.required' => 'An email needs a title',
            'title.min' => 'The title is too short, should be at least 2 chars',
        ]
    )]
    public string $title;
    #[Validate(
        rule: ['required', 'min:20', 'max:'.Constants::EMAIL_BODY],
        message: [
            'body.required' => 'An email needs a message',
            'body.min' => 'The message is too short, should be at least 20 chars',
            ]
    )]
    public string $body;

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.send-emails');
    }

    public function updatedGroup($value): void
    {
        $this->users = Collect();
        $this->body = "A message for all " . Str::ucfirst($this->group) . ":\n\n";

        switch ($value) {
            case 'players':
                $this->getPlayers();
                break;

            case 'captains':
                $this->getCaptains();
                break;

            case 'administrators':
                $this->getAdmins();
                break;

            default:
                $this->getPlayers();
        }
    }

    public function send(): void
    {
        $validated = $this->validate();
        foreach ($this->users as $user) {
            \Mail::to($user)->queue(new \App\Mail\ContactPlayers($validated['title'], $validated['body']));
        }

        $this->reset();
    }

    private function getPlayers(): void
    {
        $this->teams = Team::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->with([
                'players' => fn ($q) => $q->with('user')
            ])
            ->get();

        $this->getUsers();
    }

    private function getCaptains(): void
    {
        $this->teams = Team::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->with([
                'players' => fn ($q) => $q->whereCaptain(true)->with('user')
            ])
            ->get();

        $this->getUsers();
    }

    private function getAdmins(): void
    {
        $this->users = User::query()->has('admin')->orderBy('name')->get();
    }

    private function getUsers(): void
    {
        foreach ($this->teams as $team) {
            foreach ($team->players as $player) {
                if (!Str::contains($player->user->email, '@pgbilliard.com')) {
                    $this->users->push($player->user);
                }
            }
        }

        $this->users = $this->users->sortBy('name', SORT_NATURAL);
    }
}
