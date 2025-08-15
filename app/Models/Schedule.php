<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $format_id
 * @property int $position
 * @property int $player
 * @property int $home
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Format|null $format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Game> $games
 * @property-read int|null $games_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereFormatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule wherePlayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'format_id',
        'position',
        'player',
        'home',
    ];

    protected $casts = [
        'format_id' => 'integer',
        'position' => 'integer',
        'player' => 'integer',
        'home' => 'bool',
    ];

    public function format(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Format::class);
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
}
