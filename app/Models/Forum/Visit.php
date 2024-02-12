<?php

namespace App\Models\Forum;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Forum\Visit
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Post   $post
 * @property-read User   $user
 *
 * @method static Builder|Visit newModelQuery()
 * @method static Builder|Visit newQuery()
 * @method static Builder|Visit query()
 * @method static Builder|Visit whereCreatedAt($value)
 * @method static Builder|Visit wherePostId($value)
 * @method static Builder|Visit whereId($value)
 * @method static Builder|Visit whereUpdatedAt($value)
 * @method static Builder|Visit whereUserId($value)
 *
 * @mixin Eloquent
 */
class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
