<?php

namespace App\Models;

use App\Constants;
use Database\Factories\DateFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read Season $season
 *
 * @method static DateFactory factory($count = null, $state = [])
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
 */
class Date extends Model
{
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
    public function checkOpenWindowAccess(): bool
    {
        $now = Carbon::now()->appTimezone();
        $begin = $this->date->appTimezone()->setHour(Constants::DATEFORMAT_START);
        $end = $this->date->appTimezone()->setHour(Constants::DATEFORMAT_END);

        return $now->between($begin, $end);
    }

    /**
     * get all the players (user models) who participated in the daily events
     * and include the admins as well
     * make it unique for not sending double mails
     */
    public function players()
    {
        return
            $this->events
                ->map(
                    fn ($event) => $event
                        ->team_1
                        ->players
                        ->map(fn ($player) => $player->user)
                )
                ->merge(
                    $this->events->map(
                        fn ($event) => $event
                            ->team_2
                            ->players
                            ->map(fn ($player) => $player->user)
                            ->merge(Admin::with('user')->get()->map(fn ($admin) => $admin->user))
                    )
                )
                ->flatten()
                ->unique();
    }

    /**
     * get the team for a logged-in user based on the set day
     * if the user is not logged in, null is returned
     */
    public function getTeam()
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->events
        ->map(
            fn ($event) => $event
                ->team_1
                ->players
                ->filter(fn ($player) => $player->user_id == auth()->id())
        )
        ->merge(
            $this->events->map(
                fn ($event) => $event
                    ->team_2
                    ->players
                    ->filter(fn ($player) => $player->user_id == auth()->id())
            )
        )
        ->filter(fn ($q) => $q->count())
        ->first()
        ?->first()
        ?->team;
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
