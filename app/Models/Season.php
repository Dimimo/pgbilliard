<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property string $cycle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Date> $dates
 * @property-read int|null              $dates_count
 * @property-read Collection<int, Team> $teams
 * @property-read int|null              $teams_count
 *
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereCycle($value)
 * @method static Builder|Season whereId($value)
 * @method static Builder|Season whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Season extends Model
{
    protected $fillable = [
        'cycle',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function dates(): HasMany
    {
        return $this->hasMany(Date::class);
    }
}
