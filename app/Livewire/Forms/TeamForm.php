<?php

namespace App\Livewire\Forms;

use App\Http\Requests\TeamRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use App\Taps\Cycle;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TeamForm extends Form
{
    public Team $team;
    public Collection $users;
    public Collection $venues;

    #[Validate]
    public string $name = '';
    #[Validate]
    public ?int $venue_id = null;
    #[Validate]
    public int $season_id;
    #[Validate(['nullable', 'text'])]
    public ?string $remark = '';
    #[Validate(['nullable', 'exists:App\Models\User,id'])]
    public ?int $captain_id = null;

    public function rules(): array
    {
        return (new TeamRequest())->rules();
    }

    public function messages(): array
    {
        return (new TeamRequest())->messages();
    }

    public function setTeam(Team $team): void
    {
        $this->team = $team;
        $this->fill($team);
        // The id selects the first created captain in the team (not failsafe)
        $this->captain_id = $this->team->players()
            ->where('captain', true)
            ->orderByDesc('updated_at')
            ->first()
            ?->user_id;

        $this->users = $this->getUsersNotOccupiedExceptOwnCaptain();
        $this->venues = Venue::query()->orderBy('name')->get(['id', 'name']);
    }

    public function checkAndSetValues($name, $value): void
    {
        if ($name === 'form.name') {
            $this->validateOnly('form.name');
            $this->team->update(['name' => $value]);
        } elseif ($name === 'form.venue_id') {
            $this->validateOnly('form.venue_id');
            $this->team->update(['venue_id' => $value]);
        } elseif ($name === 'form.captain_id') {
            // selecting a new captain is different, first unset the existing players as captain, then add the new one
            // this could possibly corrupt the players list of the team in the current season, but there is no delete
            $this->team->players()->whereCaptain(true)->update(['captain' => false]);
            $this->team->players()->create(['user_id' => $value, 'captain' => true]);
            $this->captain_id = $value;
            $this->users = $this->getUsersNotOccupiedExceptOwnCaptain();
        }
    }

    public function store(): Team
    {
        $validated = $this->validate();
        $team = Team::query()->create($validated);
        if ($validated['captain_id']) {
            Player::query()
                ->create([
                    'user_id' => $validated['captain_id'],
                    'team_id' => $team->id,
                    'captain' => 1
                ]);
        }
        $this->reset(['name', 'venue_id', 'remark', 'captain_id']);
        $this->resetValidation();

        return $team;
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->team->update($validated);
        $this->team->refresh();
    }

    // a rather complex method to figure out possible captains without users that are already occupied in other teams
    // only of importance in case of an update, if new, obviously, all users are selectable
    // but allow the captain in the list that is currently selected
    // also, omit your own team, you can be selected as a member of the team you play for
    private function getUsersNotOccupiedExceptOwnCaptain(): Collection
    {
        $teams = Team::query()
            ->tap(new Cycle())
            ->where('id', '<>', $this->team->id)
            ->pluck('id')
            ->toArray();
        $players = Player::query()
            ->whereIn('team_id', $teams)
            ->pluck('user_id')
            ->toArray();
        $players = array_diff($players, \Arr::wrap($this->captain_id));
        $occupied_players = User::query()
            ->whereIn('id', $players)
            ->pluck('id')
            ->toArray();

        return User::query()
            ->whereNotIn('id', $occupied_players)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
