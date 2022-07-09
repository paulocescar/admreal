<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission_user extends LaratrustPermission
{
    use SoftDeletes;
    protected $table = 'permission_user';
    
    protected $fillable = [
        'permission_id',
        'usuario_id',
        'user_type'
    ];
}
