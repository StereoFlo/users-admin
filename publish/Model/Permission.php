<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'label'];

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return array
     */
    public static function getPermissions()
    {
        return self::select('id', 'name', 'label')->get();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function getByName(string $name)
    {
        return self::whereName($name)->firstOrFail();
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
