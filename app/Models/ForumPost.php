<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ForumPost
 *
 * @property int                                $id
 * @property string                             $title
 * @property string                             $slug
 * @property string                             $body
 * @property int                                $user_id
 * @property bool                               $is_locked
 * @property bool                               $is_sticky
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection<int, ForumComment> $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, ForumTag>     $tags
 * @property-read int|null                      $tags_count
 * @property-read User                          $user
 * @property-read Collection<int, ForumVisit>   $visits
 * @property-read int|null                      $visits_count
 *
 * @method static Builder|ForumPost newModelQuery()
 * @method static Builder|ForumPost newQuery()
 * @method static Builder|ForumPost query()
 * @method static Builder|ForumPost whereBody($value)
 * @method static Builder|ForumPost whereCreatedAt($value)
 * @method static Builder|ForumPost whereId($value)
 * @method static Builder|ForumPost whereIsLocked($value)
 * @method static Builder|ForumPost whereIsSticky($value)
 * @method static Builder|ForumPost whereSlug($value)
 * @method static Builder|ForumPost whereTitle($value)
 * @method static Builder|ForumPost whereUpdatedAt($value)
 * @method static Builder|ForumPost whereUserId($value)
 *
 * @mixin Eloquent
 */
class ForumPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'is_locked',
        'is_sticky',
    ];
    protected $casts = [
        'is_locked' => 'bool',
        'is_sticky' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'forum_post_id', 'id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(ForumVisit::class, 'forum_post_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ForumTag::class, 'forum_post_tag', 'forum_post_id', 'forum_tag_id');
    }
}
