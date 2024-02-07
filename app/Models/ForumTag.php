<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ForumTag
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $slug
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property-read Collection<int, ForumPost> $posts
 * @property-read int|null                   $posts_count
 *
 * @method static Builder|ForumTag newModelQuery()
 * @method static Builder|ForumTag newQuery()
 * @method static Builder|ForumTag query()
 * @method static Builder|ForumTag whereCreatedAt($value)
 * @method static Builder|ForumTag whereId($value)
 * @method static Builder|ForumTag whereName($value)
 * @method static Builder|ForumTag whereSlug($value)
 * @method static Builder|ForumTag whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class ForumTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(ForumPost::class, 'forum_post_tag', 'forum_tag_id', 'forum_post_id');
    }
}
