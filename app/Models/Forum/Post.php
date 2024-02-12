<?php

namespace App\Models\Forum;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Forum\Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $user_id
 * @property bool $is_locked
 * @property bool $is_sticky
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Comment>    $comments
 * @property-read int|null                    $comments_count
 * @property-read Collection<int, Tag>        $tags
 * @property-read int|null                    $tags_count
 * @property-read User                        $user
 * @property-read Collection<int, Visit> $visits
 * @property-read int|null                    $visits_count
 *
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @method static Builder|Post whereBody($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIsLocked($value)
 * @method static Builder|Post whereIsSticky($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post whereUserId($value)
 *
 * @mixin Eloquent
 */
class Post extends Model
{
    use HasFactory;

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
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'post_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
}
