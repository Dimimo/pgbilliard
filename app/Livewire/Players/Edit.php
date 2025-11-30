<?php

namespace App\Livewire\Players;

use App\Jobs\CaptainCreatedNewUser;
use App\Livewire\Forms\PlayerForm;
use App\Livewire\Forms\UserForm;
use App\Livewire\WithLoadUsersList;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    use WithLoadUsersList;

    public PlayerForm $player_form;
    public UserForm $user_form;
    public Team $team;
    public Collection $players;
    public array $occupied_players = [];
    public Collection $available_players;
    public ?int $user_id = null;
    public int $max_players;
    public bool $max_reached = false;
    public bool $show_new_player_form = true;

    public function mount(Team $team): void
    {
        $this->team = $team;
        $this->setPlayerForm();
        $this->setUserForm(new User());
        $this->getPlayers();
        $this->getPlayersActiveInCurrentSeason();
        $this->max_players = $this->team->season->players;
        $this->setMaxReached();
    }

    public function render(): View
    {
        return view('livewire.players.edit');
    }

    public function updatedUserFormName($value): void
    {
        // there are ways this update can be called: creating a new user or update an existing user (only available for admins)
        $this->validateOnly('user_form.name');
        $this->user_form->name = $value = Str::length($value) > 2
            ? Str::title($value)
            : Str::upper($value);
        if ($this->user_form->user->exists) {
            $this->user_form->update();
        } else {
            $this->user_form->email = Str::lower(Str::snake($value, '-')) . '@pgbilliard.com';
        }
    }

    public function updatedUserFormContactNr($value): void
    {
        $this->validateOnly('user_form.contact_nr');
        $this->user_form->contact_nr = $value;
    }

    public function updatedUserFormEmail($value): void
    {
        $this->validateOnly('user_form.email');
        $this->user_form->email = $value;
    }

    private function getPlayers(): void
    {
        $this->players = $this->team
            ->players()
            ->whereActive(true)
            ->with('user')
            ->get()
            ->sortBy('name')
            ->sortByDesc('captain');
    }

    public function getPlayersActiveInCurrentSeason(): void
    {
        $teams = Team::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->pluck('id')
            ->toArray();
        $players = Player::query()
            ->whereIn('team_id', $teams)
            ->whereActive(true)
            ->pluck('user_id')
            ->toArray();
        $this->occupied_players = User::query()
            ->whereIn('id', $players)
            ->pluck('name', 'id')
            ->toArray();
        $this->available_players = $this->loadUsersCollection(array_keys($this->occupied_players));
        // add the name of the last team and last played game in the dropdown list
        $this->available_players->each(
            function (User $q): void {
                $player = Player::query()
                    ->where('user_id', $q->id)
                    ->with('team')
                    ->orderByDesc('id')
                    ->first();
                $name = $q->name . ' (';
                $name .= $player ? $player->team?->name : 'none';
                $name .= ' - ' . $q->last_game->diffForHumans() . ')';
                $q->setAttribute('name', $name);
            }
        );
    }

    private function setPlayerForm(?int $user_id = null): bool
    {
        // if the player exists in the team but has been set to inactive, reactivate the player
        if ($user_id && $player = Player::query()->whereUserId($user_id)->whereTeamId($this->team->id)->first()) {
            $player->active = 1;
            $player->update();
            $this->setPlayerForm($player->id);
            return true;
        }
        $this->player_form->setPlayer(new Player([
            'captain' => 0,
            'active' => 1,
            'user_id' => $user_id,
            'team_id' => $this->team->id,
        ]));
        return false;
    }

    public function editUser(int $user_id): void
    {
        $user = User::query()->find($user_id);
        $this->setUserForm($user);
        $this->show_new_player_form = !$this->show_new_player_form;
    }

    public function editUserUpdate(): void
    {
        $this->show_new_player_form = !$this->show_new_player_form;
        $this->user_form->update();
        $this->setUserForm(new User());
        $this->setPlayerForm();
        $this->getPlayers();
        //$this->user_form->reset(['name', 'email', 'contact_nr', 'gender', 'email_verified_at', 'last_game', 'password']);
    }

    private function setUserForm(User $user): void
    {
        $this->user_form->setUser($user);
    }

    public function toggleCaptain(int $user_id): void
    {
        $player = Player::query()->find($user_id);
        $player->captain = !$player->captain;
        $player->save();
        $this->getPlayers();
    }

    public function updatedUserId($user_id): void
    {
        $updated = $this->setPlayerForm($user_id);
        if (!$updated) {
            $this->player_form->player->save();
        }
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
        $this->setPlayerForm();
        $this->reset('user_id');
        $this->setMaxReached();
    }

    public function addUser(): void
    {
        $this->validate();
        $name = $this->getPropertyValue('user_form.name');
        $user = new User([
            'name' => $name,
            'email' => Str::lower(Str::snake($name)) . '@pgbilliard.com',
            'password' => Hash::make('secret'),
            'contact_nr' => $this->getPropertyValue('user_form.contact_nr'),
            'last_game' => now(),
        ]);
        $this->setUserForm($user);

        // for an added user, 2 records are saved, a new user and a new player
        // email the creator of this user as a reminder he has done so
        $user = $this->user_form->store();
        $this->setPlayerForm($user->id);
        $this->player_form->player->save();
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
        $this->setUserForm(new User());
        $this->setMaxReached();
        $this->dispatch('user-created');
        dispatch_sync(new CaptainCreatedNewUser($user));
    }

    public function removePlayer($player_id): void
    {
        $player = Player::query()->find($player_id);
        $player->update(['active' => false]);
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
        $this->setMaxReached();
    }

    private function setMaxReached(): void
    {
        $this->max_reached = $this->players->count() >= $this->max_players;
    }
}
