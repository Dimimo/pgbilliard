<?php

namespace App\Livewire\Admin\Seasons;

use App\Constants;
use App\Livewire\WithTeamOrdering;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use WithTeamOrdering;

    public Season $season;
    public Collection $teams;
    public ?int $team_select = null;
    public bool $has_bye;

    public function rules(): array
    {
        return [
            'teams' => 'array',
            'teams.*.id' => 'required',
            'teams.*.name' => 'required|min:2|max:' . Constants::USERCHARS,
            'teams.*.venue_id' => 'required',
            'teams.*.user_id' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'teams.*.name.required' => 'A team needs a name, min 2, max ' . Constants::USERCHARS,
            'teams.*.venue_id.required' => 'A team needs a name, min 2, max ' . Constants::USERCHARS,
        ];
    }

    public function mount(Season $season): void
    {
        $this->season = $season;
        $this->has_bye = false;
        $this->getTeams();
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->number_of_teams = session('number_of_teams', $this->teams->count() > 0 ? $this->teams->count() : 6);
        // if the admin loads this page the first time, no teams yet exists, so, if a BYE is requested, create it if it doesn't exist yet
        if (!$this->has_bye && session()->has('has_bye') && session('has_bye') === true) {
            $this->addBye();
        }
        $this->i = $this->teams->count() + 1;
        session(['team_counter' => $this->i]);
    }

    public function render(): View
    {
        return view('livewire.admin.seasons.update');
    }

    public function submit(): void
    {
        $validated = $this->validate();
        foreach ($validated['teams'] as $values) {
            Team::query()->find($values['id'])->update($values);
        }
        session(['success' => count($validated) . ' teams created. Time to create the Calendar!']);
        $this->redirect(route('admin.calendar.create', ['season' => $this->season]), navigate: true);
    }

    public function updatedTeamSelect(?int $team_id): void
    {
        // if a team exists, copy it and add it to the new season
        $old_team = Team::with(
            [
                'venue',
                'players' => fn ($q) => $q->orderByDesc('updated_at')->limit($this->season->players)
            ]
        )
            ->find($team_id);

        if ($old_team) {
            $this->dropdown_teams = $this->dropdown_teams->filter(fn ($item) => $item->id !== $old_team->id);
            $new_team = Team::query()->create([
                'name' => $old_team->name,
                'venue_id' => $old_team->venue_id,
                'season_id' => $this->season->id,
            ]);

            // copy the players
            foreach ($old_team->players as $player) {
                Player::query()->create(['user_id' => $player->user_id, 'team_id' => $new_team->id, 'captain' => $player->captain]);
            }
        } else { // a new team is selected, create one with a generic name and BYE as the team
            $new_team = Team::query()->whereName('BYE')->first()->venue->teams()->create([
                'name' => 'A new team ' . ++$this->i,
                'season_id' => $this->season->id,
            ]);
        }

        $new_team->append('user_id');
        $this->teams->push($new_team);
        $this->teams->sortBy('name', SORT_NATURAL);
        $this->i++;
        $this->reset('team_select');
        $this->dispatch('teams-created');
    }

    private function getTeams(): void
    {
        $this->fill([
            'teams' => Team::query()->where('season_id', $this->season->id)->orderBy('name')->get()->each(function (Team $team) {
                if (strtoupper($team->name) === 'BYE') {
                    $this->has_bye = true;
                }
            }),
        ]);
    }

    #[On('remove-team')]
    public function removeTeam($team_id): void
    {
        $team = Team::query()->find($team_id);
        $this->authorize('delete', $team);
        if (Str::upper($team->name) === 'BYE') {
            $this->has_bye = false;
            session(['has_bye' => false]);
            $this->changeNumberOfTeams(false);
        }
        $team->players()->delete();
        $team->delete();
        $this->getTeams();
        //update the dropdown and add 1 to the $i
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->i--;
        session(['team_counter' => $this->i]);
    }

    #[On('team-added')]
    public function addTeam($team_id): void
    {
        $team = Team::query()->find($team_id);
        $team->append('user_id');
        $this->teams->push($team);
        $this->teams->sortBy('name', SORT_NATURAL);
        $this->i++;
    }

    public function addBye(): void
    {
        $this->authorize('create', Team::class);
        $this->has_bye = true;
        session(['has_bye' => true]);

        $new_team = Team::query()->create([
            'name' => 'BYE',
            'venue_id' => Venue::query()->whereName('BYE')->first()->id,
            'season_id' => $this->season->id,
        ]);
        $this->pushAndSortTeams($new_team);
    }
}
