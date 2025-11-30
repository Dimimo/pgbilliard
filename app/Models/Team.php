<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property int $venue_id
 * @property int $season_id
 * @property string|null $remark
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $user_id
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @property-read Season $season
 * @property-read Collection<int, \Illuminate\Support\Facades\Event> $team_1
 * @property-read int|null $team_1_count
 * @property-read Collection<int, \Illuminate\Support\Facades\Event> $team_2
 * @property-read int|null $team_2_count
 * @property-read Venue $venue
 * @property-read Collection<int, Player> activePlayers()
 * @property-read ?Player captain()
 * @property-read string captain_name
 *
 * @method static TeamFactory factory($count = null, $state = [])
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereRemark($value)
 * @method static Builder|Team whereSeasonId($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team whereVenueId($value)
 *
 * @mixin Model
 */
class Team extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'venue_id',
        'season_id',
        'remark',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected $with = [];

    protected $appends = [];

    /**
     * Calculates the percentages of a given score table of a team
     * The results are to be found in App\Traits\ResultsTrait
     */
    public function percentage(array $result): float
    {
        return floor(((($result['won'] / $result['max_games']) * 100) + (($result['for'] / (($result['max_games']) * 15)) * 100)) / 2);
    }

    protected function userId(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn () => $this->captain()?->user_id);
    }

    /**
     * Return the captain of the team or null if there is no captain assigned
     */
    public function captain(): ?Player
    {
        return $this->players()->where([
            ['active', true],
            ['captain', true]
        ])->first();
    }

    protected function captainName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn () => $this->captain()?->name ?: '(unknown)');
    }

    protected function contactNr(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function () {
            if (!auth()->check()) {
                return __('hidden');
            }
            return $this->captain()?->phone ?: $this->venue->contact_nr;
        });
    }

    public function hasGames(): bool
    {
        return $this->team_1()->count() || $this->team_2()->count();
    }

    public function activePlayers(): Collection
    {
        return $this->players()->whereActive(true)->get()->sortBy('name')->sortByDesc('captain');
    }

    /**************************************
     *
     * The eloquent relationships
     *
     **************************************/
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Player, $this>
     */
    public function players(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Player::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Event, $this>
     */
    public function team_1(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class, 'team1', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Event, $this>
     */
    public function team_2(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class, 'team2', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season, $this>
     */
    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Venue, $this>
     */
    public function venue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Game, $this>
     */
    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'venue_id' => 'integer',
            'season_id' => 'integer',
        ];
    }
}
