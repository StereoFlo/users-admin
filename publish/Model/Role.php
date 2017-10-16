<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Grant the given permission to a role.
     *
     * @param  Permission $permission
     *
     * @return mixed
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * @return mixed
     */
    public static function getRoles()
    {
        return self::select('id', 'name', 'label')->get();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function getByNameWithPermission($name)
    {
        return self::with('permissions')->whereName($name)->first();
    }

    /**
     * @param string $keyword
     * @param int $perPage
     *
     * @return mixed
     */
    public static function search($keyword, $perPage)
    {
        return self::where('name', 'LIKE', "%$keyword%")->orWhere('label', 'LIKE', "%$keyword%")->paginate($perPage);
    }
}
