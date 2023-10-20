<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property string $cycle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Date> $date
 * @property-read int|null $date_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $team
 * @property-read int|null $team_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Season newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Season query()
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Season whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 *
 * @mixin IdeHelperSeason
 */
class Season extends Model
{
    protected $fillable = [
        'cycle',
    ];

    /**
     * A season has many teams
     *
     * @return HasMany<Team>
     */
    public function team(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * A season has many dates
     *
     * @return HasMany<Team>
     */
    public function date(): HasMany
    {
        return $this->hasMany(Date::class);
    }
}
