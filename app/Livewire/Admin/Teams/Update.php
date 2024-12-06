<?php

namespace App\Livewire\Admin\Teams;

use App\Livewire\Forms\TeamForm;
use App\Livewire\WithTeamOrdering;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Update extends Component
{
    use WithTeamOrdering;

    public TeamForm $team_form;

    public Collection $users;

    public Collection $venues;

    public function mount(Team $team): void
    {
        $this->team_form->setTeam($team);
        $this->users = User::orderBy('name')->get(['id', 'name']);
        $this->venues = Venue::orderBy('name')->get(['id', 'name']);
    }

    public function render(): View
    {
        return view('livewire.admin.teams.update');
    }

    public function updating($name, $value): void
    {
        \Debugbar::debug('updating in Update -> '.$name.' '.$value);
        $this->authorize('create', Team::class);
        if ($name === 'team_id') {
            if ($value !== 0) {
                $old_team = Team::find($value);
                // create and push the new team
                $new_team = Team::create([
                    'name' => $old_team->name,
                    'venue_id' => $old_team->venue_id,
                    'season_id' => $this->team_form->team->season->id,
                ]);
                // create the new captain
                $new_team->append('user_id');
                Player::create(['user_id' => $old_team->captain()->user_id, 'team_id' => $new_team->id, 'captain' => 1]);
            } else {
                $new_team = Team::create([
                    'name' => 'A new team '.session('team_counter'),
                    'venue_id' => Venue::whereName('BYE')->first()->id,
                    'season_id' => $this->team_form->team->season->id,
                ]);
                $new_team->append('user_id');
            }
            $this->dispatch('update-teams', team: $new_team);
            //            $this->pushAndSortTeams($new_team);
        } elseif (Str::contains($name, 'user_id')) {
            // updates or adds a new captain, has to be manual as user_id is not a part of the teams table
            $exp = explode('.', $name);
            $this->team_form->id = $value;
            $this->team_form->team->players()->where('captain', 1)->delete();
            Player::create(['user_id' => $value, 'team_id' => $this->team_form->team->id, 'captain' => 1]);
        }
    }
}
