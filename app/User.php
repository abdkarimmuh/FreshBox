<?php

namespace App;

use App\Traits\SearchTraits;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use UserTrait;
    use HasApiTokens;
    use SearchTraits;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['allPermissions', 'profilelink', 'avatarlink', 'isme','all_roles','is_procurement'];

    protected $columns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ]
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function procurement()
    {
        return $this->belongsTo(UserProc::class,'id','user_id');
    }

    public function getAllpermissionsAttribute()
    {
        $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach ($allPermissions as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

    public function getAllRolesAttribute()
    {
        $res = [];
        $roles = $this->roles;
        foreach ($roles as $p) {
            $res[] = $p->name;
        }
        return $res;
    }

    public function UserProfile()
    {
        return $this->hasOne(UserProfile::class,'user_id','id');
    }
}
