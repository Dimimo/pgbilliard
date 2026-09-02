<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property string $cycle
 * @property bool $is_public
 * @property int $players
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Date> $dates
 * @property-read int|null              $dates_count
 * @property-read Collection<int, Rank> $ranks
 * @property-read int|null              $ranks_count
 * @property-read Collection<int, Team> $teams
 * @property-read int|null              $teams_count
 *
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season visibleTo(?User $user)
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereCycle($value)
 * @method static Builder|Season whereId($value)
 * @method static Builder|Season whereIsPublic($value)
 * @method static Builder|Season wherePlayers($value)
 * @method static Builder|Season whereUpdatedAt($value)
 *
 * @mixin Model
 */
#[\Illuminate\Database\Eloquent\Attributes\Fillable(['cycle', 'is_public', 'players'])]
class Season extends Model
{
    use HasFactory;

    public function isVisibleTo(?User $user): bool
    {
        return self::query()
            ->visibleTo($user)
            ->whereKey($this->getKey())
            ->exists();
    }

    public function scopeVisibleTo(Builder $query, ?User $user): Builder
    {
        if ($user?->isAdmin()) {
            return $query;
        }

        return $query->where(function (Builder $visibilityQuery) use ($user): void {
            $visibilityQuery->where('is_public', true);

            if ($user) {
                $visibilityQuery->orWhereHas(
                    'teams.players',
                    fn (Builder $playerQuery) => $playerQuery
                        ->where('players.user_id', $user->id)
                        ->where('players.active', true),
                );
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Team, $this>
     */
    public function teams(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Date, $this>
     */
    public function dates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Date::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Rank, $this>
     */
    public function ranks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rank::class);
    }

    /**
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'players' => 'integer',
        ];
    }
}
