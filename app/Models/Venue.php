<?php

namespace App\Models;

use Database\Factories\VenueFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Venue
 *
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property string|null $address
 * @property string|null $contact_name
 * @property string|null $contact_nr
 * @property string|null $remark
 * @property string|null $lat
 * @property string|null $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 *
 * @method static \Database\Factories\VenueFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue query()
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereContactNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Venue whereUserId($value)
 *
 * @mixin Eloquent
 *
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Venue extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'venues';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'address' => 'string',
        'contact_name' => 'string',
        'contact_nr' => 'string',
        'lat' => 'decimal',
        'lng' => 'decimal',
        'name' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'address',
        'contact_name',
        'contact_nr',
        'lat',
        'lng',
        'remark',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected function getContactName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->owner ? ($this->owner->name ?: $this->contact_name) : $this->contact_name,
        );
    }

    protected function getContactNr(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->owner ? ($this->owner->contact_nr ?: $this->contact_nr) : $this->contact_nr,
        );
    }

    protected static function newFactory(): VenueFactory
    {
        return VenueFactory::new();
    }

    /**
     * A venue has belongs to an owner (user)
     *
     * @return BelongsTo<User, Venue>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * A venue has many teams
     *
     * @return HasMany<Team>
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'venue_id', 'id');
    }

    /**
     * A venue has many events
     *
     * @return HasMany<Event>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'venue_id', 'id');
    }
}
