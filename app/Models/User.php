<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'usuario_nome', 
        'usuario_login', 
        'usuario_senha', 
        'usuario_tipo_id'
    ];

	public function userType()
	{
		return $this->hasMany(User_type::class,'usuario_id','usuario_tipo_id');
	}
    
}
