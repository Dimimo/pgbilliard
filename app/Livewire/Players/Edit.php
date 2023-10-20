<?php

namespace App\Livewire\Players;

use App\Livewire\Forms\PlayerForm;
use App\Livewire\Forms\UserForm;
use App\Livewire\WithUsersSelect;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use App\Taps\Cycle;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    use WithUsersSelect;

    public PlayerForm $player_form;

    public UserForm $user_form;

    public Team $team;

    public Collection $players;

    public array $occupied_players;

    public ?int $user_id;

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->setPlayerForm();
        $this->setUserForm(new User());
        $this->getPlayers();
        $this->getPlayersActiveInCurrentSeason();
    }

    public function render(): View
    {
        return view('livewire.players.edit');
    }

    private function getPlayers()
    {
        $this->players = $this->team->players()->get()->sortBy('name')->sortByDesc('captain');
    }

    private function getPlayersActiveInCurrentSeason()
    {
        $teams = Team::tap(new Cycle())->pluck('id')->toArray();
        $players = Player::whereIn('team_id', $teams)->pluck('user_id')->toArray();
        $this->occupied_players = User::whereIn('id', $players)->pluck('name')->toArray();
    }

    private function setPlayerForm(int $user_id = null)
    {
        $this->player_form->setPlayer(new Player([
            'captain' => 0,
            'user_id' => $user_id,
            'team_id' => $this->team->id,
        ]));
    }

    private function setUserForm(User $user)
    {
        $this->user_form->setUser($user);
    }

    public function toggleCaptain(int $user_id)
    {
        $player = Player::find($user_id);
        $player->captain = ! $player->captain;
        $player->save();
        $this->getPlayers();
    }

    public function updatedUserId($user_id)
    {
        $this->setPlayerForm($user_id);
        $this->player_form->player->save();
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
        $this->setPlayerForm();
        $this->user_id = null;
    }

    public function addUser()
    {
        $name = $this->getPropertyValue('user_form.name');
        $user = new User([
            'name' => $name,
            'email' => Str::of($name)->slug().'@puertoparrot.com',
            'password' => Hash::make('secret'),
            'contact_nr' => $this->getPropertyValue('user_form.contact_nr'),
            'last_game' => now(),
        ]);
        $this->setUserForm($user);

        $user = $this->user_form->store();
        $this->setPlayerForm($user->id);
        $this->player_form->player->save();
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
        $this->setUserForm(new User());
        $this->dispatch('user-created');
    }

    public function removePlayer($player_id)
    {
        $player = Player::find($player_id);
        $player->delete();
        $this->getPlayersActiveInCurrentSeason();
        $this->getPlayers();
    }
}
