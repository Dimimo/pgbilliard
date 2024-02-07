<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ForumVisit
 *
 * @property int            $id
 * @property int            $user_id
 * @property int            $forum_post_id
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read ForumPost $post
 * @property-read User      $user
 *
 * @method static Builder|ForumVisit newModelQuery()
 * @method static Builder|ForumVisit newQuery()
 * @method static Builder|ForumVisit query()
 * @method static Builder|ForumVisit whereCreatedAt($value)
 * @method static Builder|ForumVisit whereForumPostId($value)
 * @method static Builder|ForumVisit whereId($value)
 * @method static Builder|ForumVisit whereUpdatedAt($value)
 * @method static Builder|ForumVisit whereUserId($value)
 *
 * @mixin Eloquent
 */
class ForumVisit extends Model
{
    protected $fillable = [
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
