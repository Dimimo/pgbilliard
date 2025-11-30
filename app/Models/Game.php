<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @mixin \Illuminate\Database\Eloquent\Model
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

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function user(): BelongsTo
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
