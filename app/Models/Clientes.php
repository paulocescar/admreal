<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';

    
    protected $fillable = [
        'cliente_id',
        'cliente_nome',
        'cliente_cnpj',
        'cliente_comissao',
        'd_ins',
        'd_upt'
    ];
}
