<?php

namespace App\Models;

use App\Constants;
use Database\Factories\DateFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as PlayerList;

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
 * @property-read Collection<int, \Illuminate\Support\Facades\Event> $events
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
 * @mixin Model
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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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

    protected $with = [];

    /**
     * Check if a guest has write access to a pool day overview, this access is only valid from 12pm to 17pm
     */
    public function checkOpenWindowAccess(): bool
    {
        $now = \Illuminate\Support\Facades\Date::now()->appTimezone();
        $begin = $this->date->appTimezone()->setHour(Constants::DATEFORMAT_START);
        $end = $this->date->appTimezone()->setHour(Constants::DATEFORMAT_END);

        return $now->between($begin, $end);
    }

    /**
     * get all the players (user models) who participated in the daily events
     * and include the admins as well
     * make it unique for not sending double mails
     */
    public function players(): PlayerList
    {
        return
            $this->events
                ->map(
                    fn ($event) => $event
                        ->team_1
                        ->activePlayers()
                        ->map(fn ($player) => $player->user)
                )
                ->merge(
                    $this->events->map(
                        fn ($event) => $event
                            ->team_2
                            ->activePlayers()
                            ->map(fn ($player) => $player->user)
                            ->merge(Admin::with('user')->get()->map(fn ($admin) => $admin->user))
                    )
                )
                ->flatten()
                ->unique()
                ->select(['id', 'name', 'email', 'contact_nr']);
    }

    /**
     * get the team for a logged-in user based on the set day
     * just make sure the user exists and is active
     */
    public function getTeam(User $user): ?Team
    {
        return $this->events
        ->map(
            fn ($event) => $event
                ->team_1
                ->activePlayers()
                ->filter(fn ($player) => $player->user_id === $user->id)
        )
        ->merge(
            $this->events->map(
                fn ($event) => $event
                    ->team_2
                    ->activePlayers()
                    ->filter(fn ($player) => $player->user_id == $user->id)
            )
        )
        ->filter(fn ($c) => $c->count())
        ->first()
        ?->first()
        ?->team;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season, $this>
     */
    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Event, $this>
     */
    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class);
    }
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'season_id' => 'integer',
            'date' => 'date',
            'regular' => 'boolean',
            'title' => 'string',
        ];
    }
}
