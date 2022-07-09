<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'salas';
    protected $primaryKey = 'sala_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'sala_id', 
        'sala_nome', 
        'sala_endereco_logradouro', 
        'sala_endereco_numero',
        'sala_endereco_complemento', 
        'sala_endereco_cep', 
        'sala_endereco_cidade', 
        'sala_endereco_uf',
        'sala_endereco_gps', 
        'sala_endereco_horario', 
        'd_ins', 
        'd_upt'
    ];
}
