<?php

namespace App\Livewire\Admin\Teams;

use App\Constants;
use App\Livewire\WithUsersSelect;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    use WithUsersSelect;

    public Season $season;

    public Collection $dropdown_teams;

    public Collection $teams;

    public Collection $venues;

    public ?int $team_id = null;

    public int $number_of_teams;

    public bool $has_bye;

    public int $i = 1;

    protected $rules = [
        'teams.*.id' => 'required',
        'teams.*.name' => 'required|min:2|max:'.Constants::USERCHARS,
        'teams.*.venue_id' => 'required',
        'teams.*.user_id' => 'nullable',
    ];

    protected $messages = [
        'teams.*.name.required' => 'A team needs a name, min 2, max '.Constants::USERCHARS,
        'teams.*.venue_id.required' => 'A team needs a name, min 2, max '.Constants::USERCHARS,
    ];

    public function mount(Season $season): void
    {
        $this->season = $season;
        $this->fill([
            'teams' => Team::whereSeasonId($this->season->id)->orderBy('name')->get()->each(function (Team $team) {
                return $team->append('user_id');
            }),
        ]);
        $this->venues = Venue::where('name', '<>', 'BYE')->orderBy('name')->get();
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->number_of_teams = session('number_of_teams', 6);
        $this->has_bye = session('has_bye', 0);
        $this->i = $this->teams->count() + 1;
    }

    public function render(): View
    {
        return view('livewire.admin.teams.create');
    }

    public function submit(): void
    {
        $validated = $this->validate();
        foreach ($validated['teams'] as $values) {
            Team::find($values['id'])->update($values);
        }
        $this->dispatch('teams-created');
        session('alert', count($validated).' teams created. Time to create the Calendar!');

        $this->redirect(route('admin.calendar.create', ['season' => $this->season]), navigate: true);
    }

    public function updating($name, $value): void
    {
        if ($name === 'team_id') {
            if ($value !== 0) {
                $team = Team::find($value);
                // create and push the new team
                $new_team = Team::create([
                    'name' => $team->name,
                    'venue_id' => $team->venue_id,
                    'season_id' => $this->season->id,
                ]);
                // create the new captain
                Player::create(['user_id' => $team->captain()->user_id, 'team_id' => $new_team->id, 'captain' => 1]);
            } else {
                $new_team = Team::create([
                    'name' => 'A new team '.$this->i,
                    'venue_id' => 13,
                    'season_id' => $this->season->id,
                ]);
            }
            $this->teams->push($new_team)->each(function (Team $team) {
                return $team->append('user_id');
            });
            $this->teams = $this->teams->sortBy('name');
            //update the dropdown and add 1 to the $i
            $this->dropdown_teams = $this->getDropdownTeams();
            $this->i++;
        }
    }

    public function removeTeam($key): void
    {
        $team = Team::find($this->teams[$key]->id);
        $team->players()->first()?->delete();
        $team->delete();
        $this->teams->pull($key);
        //update the dropdown and add 1 to the $i
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->i--;
    }

    private function getDropdownTeams(): Collection
    {
        $season_ids = Season::orderByDesc('cycle')->skip(1)->take(2)->pluck('id')->toArray();
        $new_team_names = Team::whereSeasonId($this->season->id)->pluck('name')->toArray();

        return Team::whereNot('name', 'BYE')->whereIn('season_id', $season_ids)->whereNotIn('name', $new_team_names)->orderBy('name')->orderByDesc('season_id')
            ->get()->unique('name');
    }
}
