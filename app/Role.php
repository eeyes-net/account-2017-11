<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Klaravel\Ntrust\Traits\NtrustRoleTrait;

/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $perm_ids
 */
class Role extends Model
{
    use NtrustRoleTrait;

    /*
     * Role profile to get value from ntrust config file.
     */
    protected static $roleProfile = 'user';

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected $appends = [
        'perm_ids',
    ];

    public function getPermIdsAttribute()
    {
        return $this->perms()->pluck('id');
    }
}
