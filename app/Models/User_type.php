<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User_type extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'usuarios_tipos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_tipo_nome', 
        'usuario_tipo_id'
    ];
}
