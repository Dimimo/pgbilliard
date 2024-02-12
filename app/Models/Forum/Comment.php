<?php

namespace App\Models\Forum;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Forum\Comment
 *
 * @property int            $id
 * @property string         $body
 * @property int            $user_id
 * @property int            $post_id
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Post $post
 * @property-read User      $user
 *
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereBody($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment wherePostId($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 *
 * @mixin Eloquent
 */
class Comment extends Model
{
    protected $fillable = [
        'body',
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
