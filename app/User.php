<?php

namespace App;

use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use UserTrait;
    use \JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['allPermissions', 'profilelink', 'avatarlink', 'isme'];

    protected $dataTableColumns = [
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

    public function getAllpermissionsAttribute()
    {   $res = [];
        $allPermissions = $this->getAllPermissions();
        foreach($allPermissions as $p)
        {
            $res[] = $p->name;
        }
        return $res;
    }
}
