<?php

namespace App\Models;

use Database\Factories\VenueFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Event> $events
 * @property-read int|null               $events_count
 * @property-read mixed                  $get_contact_name
 * @property-read mixed                  $get_contact_nr
 * @property-read User|null              $owner
 * @property-read Collection<int, Team>  $teams
 * @property-read int|null               $teams_count
 *
 * @method static VenueFactory factory($count = null, $state = [])
 * @method static Builder|Venue newModelQuery()
 * @method static Builder|Venue newQuery()
 * @method static Builder|Venue query()
 * @method static Builder|Venue whereAddress($value)
 * @method static Builder|Venue whereContactName($value)
 * @method static Builder|Venue whereContactNr($value)
 * @method static Builder|Venue whereCreatedAt($value)
 * @method static Builder|Venue whereId($value)
 * @method static Builder|Venue whereLat($value)
 * @method static Builder|Venue whereLng($value)
 * @method static Builder|Venue whereName($value)
 * @method static Builder|Venue whereRemark($value)
 * @method static Builder|Venue whereUpdatedAt($value)
 * @method static Builder|Venue whereUserId($value)
 *
 * @mixin Eloquent
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
     * @var array<int, string>
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

    protected static function newFactory(): VenueFactory
    {
        return VenueFactory::new();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'venue_id', 'id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'venue_id', 'id');
    }

    protected function getContactName(): Attribute
    {
        return Attribute::make(get: fn () => $this->owner ? ($this->owner->name ?: $this->contact_name) : $this->contact_name);
    }

    protected function getContactNr(): Attribute
    {
        return Attribute::make(get: fn () => $this->owner ? ($this->owner->contact_nr ?: $this->contact_nr) : $this->contact_nr);
    }
}
