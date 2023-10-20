<?php

namespace App\Models;

use Database\Factories\TeamFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property int $venue_id
 * @property int $season_id
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \App\Models\Season $season
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $team_1
 * @property-read int|null $team_1_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $team_2
 * @property-read int|null $team_2_count
 * @property-read \App\Models\Venue $venue
 *
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereVenueId($value)
 *
 * @mixin Eloquent
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 *
 * @mixin IdeHelperTeam
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
     * @var array<string>
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
     * The results are to be found in CycleController@
     */
    public function percentage(array $result): float
    {
        return round(((($result['won'] / $result['max_games']) * 100) + (($result['for'] / (($result['max_games']) * 15)) * 100)) / 2);
    }

    /**
     * Return the captain of the team or null if there is no captain assigned
     */
    public function captain(): ?Player
    {
        return $this->players()->where('captain', '1')->get()->first();
    }

    public function hasGames(): bool
    {
        return $this->team_1()->count() || $this->team_2()->count();
    }

    protected static function newFactory(): TeamFactory
    {
        return TeamFactory::new();
    }

    /**************************************
     *
     * The eloquent relationships
     *
     **************************************/

    /**
     * A team belongs to a season
     *
     * @return BelongsTo<Season, Team>
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * A team belongs to a venue
     *
     * @return BelongsTo<Venue, Team>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    /**
     * A team has many players
     *
     * @return HasMany<Player>
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    /**
     * A team has many events as team 1
     *
     * @return HasMany<Event>
     */
    public function team_1(): HasMany
    {
        return $this->hasMany(Event::class, 'team1', 'id');
    }

    /**
     * A team has many events as team 2
     *
     * @return HasMany<Event>
     */
    public function team_2(): HasMany
    {
        return $this->hasMany(Event::class, 'team2', 'id');
    }
}
