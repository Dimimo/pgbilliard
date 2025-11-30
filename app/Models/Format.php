<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Format
 *
 * @property int $id
 * @property string $name
 * @property string $details
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Schedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Format whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Format extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'details',
        'user_id',
    ];

    public function checkGameNumbers(int $player, bool $home): int
    {
        return $this->schedules()->where([['player', $player], ['home', $home]])->count();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
