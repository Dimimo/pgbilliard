<?php

namespace App\Livewire\Admin\Teams;

use App\Constants;
use App\Livewire\WithTeamOrdering;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    use WithTeamOrdering;

    public Season $season;

    public Collection $teams;

    public bool $has_bye;

    public int $i = 1;

    protected $rules = [
        'teams' => 'array',
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
        $this->has_bye = false;
        $this->getTeams();
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->number_of_teams = session('number_of_teams', $this->teams->count() > 0 ? $this->teams->count() : 6);
        // if the admin loads this page the first time, no teams yet exists, so, if a BYE is requested, create it if it doesn't exist yet
        if (! $this->has_bye && session()->has('has_bye') && session('has_bye') === true) {
            $this->addBye();
        }
        $this->i = $this->teams->count() + 1;
        session(['team_counter' => $this->i]);
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
        \Debugbar::debug('updating in Create -> '.$name.' '.$value);
        $this->authorize('create', Team::class);
        if ($name === 'team_id') {
            if ($value !== 0) {
                $old_team = Team::find($value);
                // create and push the new team
                $new_team = Team::create([
                    'name' => $old_team->name,
                    'venue_id' => $old_team->venue_id,
                    'season_id' => $this->season->id,
                ]);
                // create the new captain
                $new_team->append('user_id');
                Player::create(['user_id' => $old_team->captain()->user_id, 'team_id' => $new_team->id, 'captain' => 1]);
            } else {
                $new_team = Team::create([
                    'name' => 'A new team '.$this->i,
                    'venue_id' => Venue::whereName('BYE')->first()->id,
                    'season_id' => $this->season->id,
                ]);
                $new_team->append('user_id');
            }
            $this->pushAndSortTeams($new_team);
        } elseif (Str::contains($name, 'user_id')) {
            // updates or adds a new captain, has to be manual as user_id is not a part of the teams table
            $exp = explode('.', $name);
            $this->teams[$exp[1]]->user_id = $value;
            $this->teams[$exp[1]]->players()->where('captain', 1)->delete();
            Player::create(['user_id' => $value, 'team_id' => $this->teams[$exp[1]]->id, 'captain' => 1]);
        }
    }

    private function getTeams(): void
    {
        $this->fill([
            'teams' => Team::where('season_id', $this->season->id)->orderBy('name')->get()->each(function (Team $team) {
                if (strtoupper($team->name) === 'BYE') {
                    $this->has_bye = true;
                }
            }),
        ]);
    }

    public function removeTeam($id): void
    {
        $team = Team::find($id);
        $this->authorize('delete', $team);
        if (strtoupper($team->name) === 'BYE') {
            $this->has_bye = false;
            session(['has_bye' => false]);
        }
        $team->players()->delete();
        $team->delete();
        $this->teams->pull($team->id);
        $this->changeNumberOfTeams(false);
        //update the dropdown and add 1 to the $i
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->i--;
        session(['team_counter' => $this->i]);
    }

    public function addBye(): void
    {
        $this->authorize('create', Team::class);
        $this->has_bye = true;
        session(['has_bye' => true]);

        $new_team = Team::create([
            'name' => 'BYE',
            'venue_id' => Venue::whereName('BYE')->first()->id,
            'season_id' => $this->season->id,
        ]);
        $this->pushAndSortTeams($new_team);
    }
}
