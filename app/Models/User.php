<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable 
{
    use HasFactory, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ieis-crm.users'; 
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $connection = 'mysql'; // This should use the connection defined in .env

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    // This can stay if you're using a single-role-per-user approach via `role_id`
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // ❌ Commented out: This overrides Spatie's roles() relationship and causes the error
    /*
    public function roles()
    {
        return collect([$this->role]);
    }
    */

    // ❌ This method manually checks permissions by looping through custom roles; Spatie already provides hasPermissionTo()
    /*
    public function hasPermissionTo($name)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $name)) {
                return true;
            }
        }
        return false;
    }
    */

    // ❌ This custom hasRole() is not needed; Spatie provides this method too
    /*
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->name === $role;
        }
        return $this->role->id === $role->id;
    }
    */
}
