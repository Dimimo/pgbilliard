<?php

namespace App\Models;

use Database\Factories\DateFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Date
 *
 * @property int $id
 * @property int $season_id
 * @property Carbon $date
 * @property bool $regular
 * @property string|null $title
 * @property string|null $remark
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \App\Models\Season $season
 *
 * @method static \Database\Factories\DateFactory factory($count = null, $state = [])
 * @method static Builder|Date newModelQuery()
 * @method static Builder|Date newQuery()
 * @method static Builder|Date query()
 * @method static Builder|Date whereCreatedAt($value)
 * @method static Builder|Date whereDate($value)
 * @method static Builder|Date whereId($value)
 * @method static Builder|Date whereRegular($value)
 * @method static Builder|Date whereRemark($value)
 * @method static Builder|Date whereSeasonId($value)
 * @method static Builder|Date whereTitle($value)
 * @method static Builder|Date whereUpdatedAt($value)
 *
 * @mixin Eloquent
 *
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Date extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dates';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'regular' => 'boolean',
        'title' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'season_id',
        'date',
        'regular',
        'title',
        'remark',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected $with = ['events'];

    /**
     * Check if a guest has write access to a pool day overview, this access is only valid from 12pm to 17pm
     */
    public function checkIfGuestHasWritableAccess(): bool
    {
        $now = Carbon::now();
        $begin = $this->date->format('Y-m-d 12:00:00');
        $end = $this->date->format('Y-m-d 20:00:00');

        return $now->between($begin, $end);
    }

    protected static function newFactory(): DateFactory
    {
        return DateFactory::new();
    }

    /**
     * A date belongs to a season
     *
     * @return BelongsTo<Season, Team>
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * A date has many events
     *
     * @return HasMany<Event>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
