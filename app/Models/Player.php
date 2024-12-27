<?php

namespace App\Models;

use Database\Factories\PlayerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $team_id
 * @property bool $captain
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $contact_nr
 * @property-read string $email
 * @property-read string $gender
 * @property-read string $name
 * @property-read Team|null $team
 * @property-read User|null $user
 *
 * @method static PlayerFactory factory($count = null, $state = [])
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereCaptain($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereTeamId($value)
 * @method static Builder|Player whereUpdatedAt($value)
 * @method static Builder|Player whereUserId($value)
 *
 * @mixin Eloquent
 */
class Player extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'team_id' => 'integer',
        'captain' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'team_id',
        'captain',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected $with = ['team'];

    protected $appends = ['name', 'phone'];

    public function isCaptain(Team $team): bool
    {
        if (! $this->captain) {
            return false;
        }

        return $this->team->id === $team->id;
    }

    protected function name(): Attribute
    {
        return Attribute::make(get: fn () => $this->user?->name);
    }

    protected function phone(): Attribute
    {
        return Attribute::make(get: fn () => $this->user?->contact_nr);
    }

    protected function gender(): Attribute
    {
        return Attribute::make(get: fn () => $this->user?->gender);
    }

    protected function email(): Attribute
    {
        return Attribute::make(get: fn () => $this->user?->email);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id', 'id');
    }
}
