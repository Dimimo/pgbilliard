<?php

namespace App\Models;

use App\Constants;
use Database\Factories\DateFactory;
use Eloquent;
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
 * @property \Illuminate\Support\Carbon $date
 * @property bool $regular
 * @property string|null $title
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \App\Models\Season $season
 *
 * @method static \Database\Factories\DateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Date newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Date newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Date query()
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereRegular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Date whereUpdatedAt($value)
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 *
 * @mixin Eloquent
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
        $begin = $this->date->format(Constants::DATEFORMAT_START);
        $end = $this->date->format(Constants::DATEFORMAT_END);

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
