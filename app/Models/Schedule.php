<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $format_id
 * @property int $position
 * @property int $player
 * @property int $home
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Format|null $format
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

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }
}
