<?php

namespace App\Models\Chat;

use App\Models\User;
use Database\Factories\Chat\ChatRoomFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Chat\ChatRoom
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $private
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ChatMessage> $messages
 * @property-read int|null                     $messages_count
 * @property-read Collection<int, User>        $users
 * @property-read int|null                     $users_count
 *
 * @method static ChatRoomFactory factory($count = null, $state = [])
 * @method static Builder|ChatRoom newModelQuery()
 * @method static Builder|ChatRoom newQuery()
 * @method static Builder|ChatRoom query()
 * @method static Builder|ChatRoom whereCreatedAt($value)
 * @method static Builder|ChatRoom whereId($value)
 * @method static Builder|ChatRoom whereName($value)
 * @method static Builder|ChatRoom wherePrivate($value)
 * @method static Builder|ChatRoom whereUpdatedAt($value)
 * @method static Builder|ChatRoom whereUserId($value)
 *
 * @mixin Eloquent
 */
class ChatRoom extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat_rooms';

    protected $fillable = [
        'name',
        'user_id',
        'private',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected static function newFactory(): ChatRoomFactory
    {
        return ChatRoomFactory::new();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
