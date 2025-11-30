<?php

namespace App\Models;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use App\Models\Forum\Comment;
use App\Models\Forum\Post;
use App\Models\Forum\Visit;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $contact_nr
 * @property string $gender
 * @property Carbon|null $last_game
 * @property Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Admin|null                                                $admin
 * @property-read Collection<int, Admin>                                    $assignees
 * @property-read int|null                                                  $assignees_count
 * @property-read Collection<int, ChatMessage>                              $chatMessages
 * @property-read int|null                                                  $chat_messages_count
 * @property-read Collection<int, ChatRoom>                                 $chatRooms
 * @property-read int|null                                                  $chat_rooms_count
 * @property-read Collection<int, Comment>                                  $comments
 * @property-read int|null                                                  $comments_count
 * @property-read Collection<int, Player>                                   $games
 * @property-read int|null                                                  $games_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null                                                  $notifications_count
 * @property-read Collection<int, Player>                                   $players
 * @property-read int|null                                                  $players_count
 * @property-read Collection<int, Post>                                     $posts
 * @property-read int|null                                                  $posts_count
 * @property-read Collection<int, PersonalAccessToken>                      $tokens
 * @property-read int|null                                                  $tokens_count
 * @property-read Venue|null                                                $venue
 * @property-read Collection<int, Visit>                                    $visits
 * @property-read int|null                                                  $visits_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereContactNr($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastGame($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', // my addition
        'name',
        'email',
        'password',
        'contact_nr',
        'gender',
        'last_game',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return session('is_admin');
    }

    public function isSuperAdmin(): bool
    {
        return Admin::query()->whereUserId($this->id)->whereSuperAdmin(1)->exists();
    }

    /**
     * Checks if the user is allowed to join a room
     */
    public function canJoinRoom(?int $roomId): bool
    {
        if ($roomId) {
            return true;
        }

        return false;
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function assignees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Admin::class, 'assigned_by', 'id');
    }

    public function venue(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Venue::class, 'user_id', 'id');
    }

    public function players(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Player::class, 'user_id', 'id');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function visits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Visit::class, 'user_id', 'id');
    }

    public function chatMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chatRooms(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ChatRoom::class)->withTimestamps();
    }

    public function formats(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Format::class);
    }

    public function ranks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rank::class);
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_game' => 'date',
            'password' => 'hashed',
        ];
    }
}
