<?php

namespace App\Models;

use Database\Factories\AdminFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $assigned_by
 * @property bool $super_admin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $assigned
 * @property-read User      $user
 *
 * @method static AdminFactory factory($count = null, $state = [])
 * @method static Builder|Admin newModelQuery()
 * @method static Builder|Admin newQuery()
 * @method static Builder|Admin query()
 * @method static Builder|Admin whereAssignedBy($value)
 * @method static Builder|Admin whereCreatedAt($value)
 * @method static Builder|Admin whereId($value)
 * @method static Builder|Admin whereSuperAdmin($value)
 * @method static Builder|Admin whereUpdatedAt($value)
 * @method static Builder|Admin whereUserId($value)
 *
 * @mixin Eloquent
 */
class Admin extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assigned_by',
        'super_admin',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'assigned_by' => 'integer',
            'super_admin' => 'bool',
        ];
    }
}
