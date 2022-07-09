<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sorteios extends Model
{
    public $guarded = [];
    public $timestamps = false;
    protected $table = 'sorteios';
    
    protected $fillable = [
        'cliente_id',
        'sala_id', 
        'sorteio_id', 
        'sorteio_tipo', 
        'sorteio_nome',
        'sorteio_quantidade_tickets_pre', 
        'sorteio_quantidade_tickets_livre', 
        'sorteio_quantidade_venda', 
        'sorteio_quantidade_numeros',
        'sorteio_quantidade_rodadas', 
        'sorteio_quantidade_giros', 
        'sorteio_selecao_tipo', 
        'sorteio_selecao_limite', 
        'sorteio_selecao_forcar', 
        'sorteio_criacao_data', 
        'sorteio_liberacao_data', 
        'sorteio_inicio_data', 
        'sorteio_final_data', 
        'sorteio_previsao_data', 
        'sorteio_cartela_preco', 
        'sorteio_indice_rodada', 
        'sorteio_indice_giro', 
        'sorteio_identificador', 
        'sorteio_processo_orgao', 
        'sorteio_processo_numero', 
        'sorteio_premio_rodada_valor', 
        'sorteio_premio_rodada_nome', 
        'sorteio_premio_giro_valor', 
        'sorteio_premio_giro_nome', 
        'd_ins', 
        'd_upt'
    ];
}
