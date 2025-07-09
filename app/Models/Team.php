<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read Collection<int, Event> $team_1
 * @property-read int|null $team_1_count
 * @property-read Collection<int, Event> $team_2
 * @property-read int|null $team_2_count
 * @property-read Venue $venue
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
 * @mixin Eloquent
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
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'venue_id' => 'integer',
        'season_id' => 'integer',
    ];

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

    /**
     * Calculates the percentages of a given score table of a team
     * The results are to be found in App\Traits\ResultsTrait
     */
    public function percentage(array $result): float
    {
        return round(((($result['won'] / $result['max_games']) * 100) + (($result['for'] / (($result['max_games']) * 15)) * 100)) / 2);
    }

    public function getUserIdAttribute()
    {
        return $this->captain()?->user_id;
    }

    /**
     * Return the captain of the team or null if there is no captain assigned
     */
    public function captain(): ?Player
    {
        return $this->players()->where('captain', '1')->first();
    }

    public function hasGames(): bool
    {
        return $this->team_1()->count() || $this->team_2()->count();
    }

    public function activePlayers(): Collection
    {
        return $this->players->filter(fn ($player) => $player->active === true);
    }

    /**************************************
     *
     * The eloquent relationships
     *
     **************************************/

    public function players(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function team_1(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class, 'team1', 'id');
    }

    public function team_2(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class, 'team2', 'id');
    }

    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function venue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
}
