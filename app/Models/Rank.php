<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rank
 *
 * @property int $id
 * @property int $season_id
 * @property int $player_id
 * @property int $user_id
 * @property int $max_games total of days played
 * @property int $participated participated days played
 * @property int $won
 * @property int $lost
 * @property int $played sum of won and lost
 * @property int $percentage defines the ranking
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Player|null $player
 * @property-read Season|null $season
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereLost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereMaxGames($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereParticipated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank wherePlayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rank whereWon($value)
 * @mixin Model
 */
class Rank extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id',
        'player_id',
        'user_id',
        'max_games',
        'participated',
        'won',
        'lost',
        'played',
        'percentage',
    ];

    protected $with = ['player', 'user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Season, $this>
     */
    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Season::class);
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
    /**
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'season_id' => 'integer',
            'player_id' => 'integer',
            'user_id' => 'integer',
            'max_games' => 'integer',
            'participated' => 'integer',
            'won' => 'integer',
            'lost' => 'integer',
            'played' => 'integer',
            'percentage' => 'integer',
        ];
    }
}
