<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_client extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'usuarios_clientes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id', 
        'cliente_id'
    ];
}
