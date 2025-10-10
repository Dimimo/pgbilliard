<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property int $date_id
 * @property int $venue_id
 * @property int $team1
 * @property int $team2
 * @property int|null $score1
 * @property int|null $score2
 * @property boolean $confirmed
 * @property string|null $remark
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Date $date
 * @property-read Collection<int, Game> $games
 * @property-read int|null              $games_count
 * @property-read Team|null $team_1
 * @property-read Team|null $team_2
 * @property-read Venue $venue
 *
 * @method static EventFactory factory($count = null, $state = [])
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereConfirmed($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDateId($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereRemark($value)
 * @method static Builder|Event whereScore1($value)
 * @method static Builder|Event whereScore2($value)
 * @method static Builder|Event whereTeam1($value)
 * @method static Builder|Event whereTeam2($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event whereVenueId($value)
 *
 * @mixin Eloquent
 */
class Event extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date_id' => 'integer',
        'venue_id' => 'integer',
        'team1' => 'integer',
        'team2' => 'integer',
        'score1' => 'integer',
        'score2' => 'integer',
        'confirmed' => 'bool',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'date_id',
        'venue_id',
        'team1',
        'team2',
        'score1',
        'score2',
        'confirmed',
        'remark',
        'games',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array<int, string>
     */
    protected $with = [];

    public function playerBelongsToEvent(User $user): bool
    {
        return $this->team_1->activePlayers()->where('user_id', $user->id)->count()
            || $this->team_2->activePlayers()->where('user_id', $user->id)->count();
    }

    public function hasScore(): bool
    {
        return !is_null($this->score1) && !is_null($this->score2) && ($this->score1 != 0 && $this->score2 != 0);
    }

    public function date(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Date::class, 'date_id', 'id');
    }

    public function venue(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    public function team_1(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team1', 'id');
    }

    public function team_2(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class, 'team2', 'id');
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function position(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Position::class);
    }
}
