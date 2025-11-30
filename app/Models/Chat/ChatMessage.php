<?php

namespace App\Models\Chat;

use App\Models\User;
use Database\Factories\Chat\ChatMessageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Chat\ChatMessage
 *
 * @property int $id
 * @property string $message
 * @property int $user_id
 * @property int|null $room_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ChatRoom|null $room
 * @property-read User|null $user
 *
 * @method static ChatMessageFactory factory($count = null, $state = [])
 * @method static Builder|ChatMessage newModelQuery()
 * @method static Builder|ChatMessage newQuery()
 * @method static Builder|ChatMessage query()
 * @method static Builder|ChatMessage whereChatRoomId($value)
 * @method static Builder|ChatMessage whereCreatedAt($value)
 * @method static Builder|ChatMessage whereId($value)
 * @method static Builder|ChatMessage whereMessage($value)
 * @method static Builder|ChatMessage whereUpdatedAt($value)
 * @method static Builder|ChatMessage whereUserId($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class ChatMessage extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chat_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'user_id',
        'chat_room_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected $with = ['room'];

    protected static function newFactory(): ChatMessageFactory
    {
        return ChatMessageFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id', 'id');
    }
}
