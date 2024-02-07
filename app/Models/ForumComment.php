<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ForumComment
 *
 * @property int            $id
 * @property string         $body
 * @property int            $user_id
 * @property int            $forum_post_id
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read ForumPost $post
 * @property-read User      $user
 *
 * @method static Builder|ForumComment newModelQuery()
 * @method static Builder|ForumComment newQuery()
 * @method static Builder|ForumComment query()
 * @method static Builder|ForumComment whereBody($value)
 * @method static Builder|ForumComment whereCreatedAt($value)
 * @method static Builder|ForumComment whereForumPostId($value)
 * @method static Builder|ForumComment whereId($value)
 * @method static Builder|ForumComment whereUpdatedAt($value)
 * @method static Builder|ForumComment whereUserId($value)
 *
 * @mixin Eloquent
 */
class ForumComment extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'forum_post_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id', 'id');
    }
}
