<?php

namespace App\Livewire\Admin;

use App\Models\Date;
use App\Models\Event;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use DB;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use stdClass;

class Database extends Component
{
    public Collection $seasons;

    public ?Collection $dates = null;

    public bool $converted = false;

    public ?string $messages = null;

    public function mount(): void
    {
        $this->seasons = $this->getSeasons();
    }

    public function render(): View
    {
        return view('livewire.admin.database')->with(['messages' => $this->messages]);
    }

    public function getSeasons(): Collection
    {
        $seasons = DB::connection('parrot')->table('pool_dates')->select(['cycle'])->distinct()->orderBy('cycle', 'desc')->get();
        foreach ($seasons as $season) {
            $season->done = Season::whereCycle($season->cycle)->exists();
        }

        return $seasons;
    }

    public function getDates($cycle): void
    {
        $this->messages = "Follow the output of the conversion, we will transfer season $cycle ...\n";
        $this->messages .= "Click 'Copy the season $cycle' to start\n\n";
        $this->_getDates($cycle);
        $this->converted = Season::whereCycle($cycle)->count() == 1;
    }

    private function _getDates($cycle): void
    {
        $this->dates = DB::connection('parrot')->table('pool_dates')->where('cycle', $cycle)->orderBy('date')->get();
    }

    public function convertToNewDB($cycle): void
    {
        // whe should start with the players by filling up the users database
        $this->_convertPlayersToUsers();
        //always create the venues first, as they are season independent
        $this->_createVenues();
        //let's create all season dependent value to the new table
        $season = $this->_createNewSeason($cycle);
        $this->_convertTeams($season);
        $this->_convertPlayers($season);
        $this->_convertDates($season);
        //update the seasons, make the new season green to avoid doubles
        $this->_getDates($cycle);
        $this->converted = true;
        $this->seasons = $this->getSeasons();
    }

    private function _createNewSeason($cycle): Season
    {
        $this->messages .= "The new season $cycle is created\n\n";

        return Season::create(['cycle' => $cycle]);
    }

    private function _createVenues(): void
    {
        if (! Venue::count()) {
            $this->messages .= "The venues are not create yet, creating ... '\n";
            $venues = DB::connection('parrot')->table('pool_venues')->get();
            foreach ($venues as $venue) {
                Venue::create((array) $venue);
                $this->messages .= "  $venue->name is created\n";
            }
            $this->messages .= count($venues)." has been created. This is a one time action\n\n";
            $this->dispatch('update_messages', message: $this->messages);
        }
    }

    private function _convertTeams(Season $season): void
    {
        $this->messages .= "Then we transfer the 'teams' table for season $season->cycle:\n\n";
        $teams = DB::connection('parrot')->table('pool_teams')->where('cycle', $season->cycle)->get();
        foreach ($teams as $team) {
            $this->messages .= "  Converting $team->name to the new database ... ";
            Team::create([
                'id' => $team->id,
                'name' => $team->name,
                'venue_id' => $team->pool_venue_id,
                'season_id' => $season->id,
                'remark' => $team->remark,
            ]);
            $this->messages .= "done!\n";
        }
        $this->messages .= "\n{$teams->count()} 'teams' converted\n\n\n";
    }

    private function _convertPlayersToUsers(): void
    {
        if (User::count() === 1) {
            $this->messages .= "First we copy the 'players' to the 'users' table:\n\n";
            $players = DB::connection('parrot')
                ->table('pool_players')
                ->orderByDesc('id')
                ->orderByDesc('contact_nr')
                ->get()
                ->unique('name');

            foreach ($players as $player) {
                $this->messages .= "  User $player->name ... ";
                User::create([
                    'name' => $player->name,
                    'email' => Str::lower(Str::snake($player->name)).'@pgbilliard.com',
                    'password' => Hash::make('secret'),
                    'contact_nr' => $player->contact_nr,
                    'last_game' => $player->updated_at,
                ]);
                $this->messages .= "done!\n";
            }
            $this->messages .= "\n{$players->count()} 'players' copied to users\n\n\n";
            $this->dispatch('update_messages', message: $this->messages);
        }

    }

    private function _convertPlayers(Season $season): void
    {
        $this->messages .= "And finally we transfer the 'players' table:\n\n";
        $players = DB::connection('parrot')->table('pool_players')->where('cycle', $season->cycle)->get();
        foreach ($players as $player) {
            $this->messages .= "  Copying $player->name ... ";
            $user = User::whereName($player->name)->first();
            Player::create([
                'id' => $player->id,
                'user_id' => $user->id,
                'team_id' => $player->pool_team_id,
                'captain' => $player->captain,
            ]);
            $this->messages .= "done!\n";
        }
        $this->messages .= "\n{$players->count()} 'players' copied\n\n\n";
        $this->dispatch('update_messages', message: $this->messages);
    }

    private function _convertDates(Season $season): void
    {
        $this->messages .= "Now we transfer the 'dates' table:\n\n";
        $this->_getDates($season->cycle);
        foreach ($this->dates as $date) {
            $this->messages .= "  Copying $date->date ... ";
            Date::create([
                'id' => $date->id,
                'season_id' => $season->id,
                'date' => $date->date,
                'regular' => $date->regular,
                'title' => $date->title,
                'remark' => $date->remark,
            ]);
            $this->_convertEvents($date);
            $this->messages .= "done!\n";
        }
        $this->messages .= "\n{$this->dates->count()} 'dates' copied\n\n\n";
    }

    private function _convertEvents(stdClass $date): void
    {
        $events = DB::connection('parrot')->table('pool_events')->where('pool_date_id', $date->id)->get();
        foreach ($events as $event) {
            $data = array_merge((array) $event, [
                'date_id' => $event->pool_date_id,
                'venue_id' => $event->pool_venue_id,
            ]);
            Event::create($data);
        }
        $this->messages .= "{$events->count()} games copied ... ";
    }
}
