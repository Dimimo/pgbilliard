<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Date $date
 * @property-read \App\Models\Team|null $team_1
 * @property-read \App\Models\Team|null $team_2
 * @property-read \App\Models\Venue $venue
 *
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereScore1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereScore2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTeam1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereTeam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereVenueId($value)
 *
 * @mixin \Eloquent
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 *
 * @mixin IdeHelperEvent
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
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'date_id',
        'venue_id',
        'team1',
        'team2',
        'score1',
        'score2',
        'remark',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['team_1', 'team_2'];

    protected static function newFactory(): EventFactory
    {
        return EventFactory::new();
    }

    /**
     * An event belongs to a date
     *
     * @return BelongsTo<Date, Event>
     */
    public function date(): BelongsTo
    {
        return $this->belongsTo(Date::class, 'date_id', 'id');
    }

    /**
     * An event belongs to a venue
     *
     * @return BelongsTo<Venue, Event>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }

    /**
     * An event belongs to team 1
     *
     * @return BelongsTo<Team, Event>
     */
    public function team_1(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team1', 'id');
    }

    /**
     * An event belongs to team 2
     *
     * @return BelongsTo<Team, Event>
     */
    public function team_2(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team2', 'id');
    }
}
