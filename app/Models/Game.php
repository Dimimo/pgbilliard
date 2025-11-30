<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $schedule_id
 * @property int $event_id
 * @property int $team_id
 * @property int|null $player_id
 * @property int $user_id
 * @property int $position
 * @property bool $home
 * @property bool|null $win
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Support\Facades\Event $event
 * @property-read Player $player
 * @property-read Schedule|null $schedule
 * @property-read Team $team
 * @method static \Database\Factories\GameFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereWin($value)
 * @mixin Model
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'event_id',
        'team_id',
        'player_id',
        'user_id',
        'position',
        'home',
        'win',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Schedule, $this>
     */
    public function schedule(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Event, $this>
     */
    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Team, $this>
     */
    public function team(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Player, $this>
     */
    public function player(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected function casts(): array
    {
        return [
            'home' => 'bool',
            'win' => 'bool',
            'schedule_id' => 'int',
            'event_id' => 'int',
            'team_id' => 'int',
            'player_id' => 'int',
            'user_id' => 'int',
            'position' => 'int',
        ];
    }
}
