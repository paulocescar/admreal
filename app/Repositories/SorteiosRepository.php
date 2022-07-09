<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Salas;
use App\Models\Clientes;
use App\Models\Sorteios;
use Datatables;

/**
 * Class SorteiosRepository.
 */
class SorteiosRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Sorteios::class;
    }


    public function index(){
        
        $data = Sorteios::select(array(
            'sorteios.cliente_id',
            'sorteios.sala_id', 
            'sorteios.sorteio_id', 
            'sorteios.sorteio_tipo', 
            'sorteios.sorteio_nome',
            'sorteios.sorteio_quantidade_tickets_pre', 
            'sorteios.sorteio_quantidade_tickets_livre', 
            'sorteios.sorteio_quantidade_venda', 
            'sorteios.sorteio_quantidade_numeros',
            'sorteios.sorteio_quantidade_rodadas', 
            'sorteios.sorteio_quantidade_giros', 
            'sorteios.sorteio_selecao_tipo', 
            'sorteios.sorteio_selecao_limite', 
            'sorteios.sorteio_selecao_forcar', 
            'sorteios.sorteio_criacao_data', 
            'sorteios.sorteio_liberacao_data', 
            'sorteios.sorteio_inicio_data', 
            'sorteios.sorteio_final_data', 
            'sorteios.sorteio_previsao_data', 
            'sorteios.sorteio_cartela_preco', 
            'sorteios.sorteio_indice_rodada', 
            'sorteios.sorteio_indice_giro', 
            'sorteios.sorteio_identificador', 
            'sorteios.sorteio_processo_orgao', 
            'sorteios.sorteio_processo_numero', 
            'sorteios.sorteio_premio_rodada_valor', 
            'sorteios.sorteio_premio_rodada_nome', 
            'sorteios.sorteio_premio_giro_valor', 
            'sorteios.sorteio_premio_giro_nome', 
            'sorteios.d_ins', ))->orderBy('sorteios.sala_id','DESC');
        
        $dt = Datatables::of($data);

        $clientes = Clientes::get();
        $salas = Salas::get();
        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';
        })->editColumn('cliente_id', function ($data) use($clientes) {
          return $data->cliente_id ? $this->getClienteNameById($clientes, $data->cliente_id) : '';
        })->editColumn('sala_id', function ($data) use($salas) {
            return $data->sala_id ? $this->getSalaNameById($salas, $data->sala_id) : '';
        })->addColumn('action', function ($data) use($clientes) {
            return '<a href="#edit-'.$data->sala_id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->sala_id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->sala_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('sweepstakes.update', ['sweepstake' => $data->sala_id]).'" method="post">
                    <div class="container">
                        '.csrf_field().'
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="'.$data->sala_id.'">
      
                        <div class="form-group">
                        <label for="nome">Clientes*</label>
                          <select class="form-control js-example-basic-single" style="width: 100%!important;" name="Cliente_id" required>
                            '.$this->statusToHtml($clientes, $data->cliente_id).'
                          </select>
                      </div>
    
                        <div class="form-group">
                            <label for"nome">Numero da sala</label>
                            <input type="number" step="1" class="form-control" name="sala_id" value="'.$data->sala_id.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Sorteio</label>
                            <input type="text" class="form-control" name="sorteio_id" value="'.$data->sorteio_id.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Tipo do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_tipo" value="'.$data->sorteio_tipo.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Nome do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_nome" value="'.$data->sorteio_nome.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade de tickets de pré-venda</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_tickets_pre" value="'.$data->sorteio_quantidade_tickets_pre.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade de Tickets Livres</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_tickets_livre" value="'.$data->sorteio_quantidade_tickets_live.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade à venda</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_venda" value="'.$data->sorteio_quantidade_venda.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade de numeros</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_numeros" value="'.$data->sorteio_quantidade_numeros.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade de rodadas</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_rodadas" value="'.$data->sorteio_quantidade_rodadas.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Quantidade de giros</label>
                            <input type="text" class="form-control" name="sorteio_quantidade_giros" value="'.$data->sorteio_quantidade_giros.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Seleção tipo</label>
                            <input type="text" class="form-control" name="sorteio_selecao_tipo" value="'.$data->sorteio_selecao_tipo.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Limite de seleção</label>
                            <input type="text" class="form-control" name="sorteio_selecao_limite" value="'.$data->sorteio_selecao_limite.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Forçar minímo de seleção</label>
                            <input type="text" class="form-control" name="sorteio_selecao_forcar" value="'.$data->sorteio_selecao_forcar.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de criação</label>
                            <input type="text" class="form-control" name="sorteio_criacao_data" value="'.$data->sorteio_criacao_data.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de liberação do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_liberacao_data" value="'.$data->sorteio_liberacao_data.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de início do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_inicio_data" value="'.$data->sorteio_inicio_data.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de finalização do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_final_data" value="'.$data->sorteio_final_data.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de previsão</label>
                            <input type="text" class="form-control" name="sorteio_previsao_data" value="'.$data->sorteio_previsao_data.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Preço das cartelas</label>
                            <input type="text" class="form-control" name="sorteio_cartela_preco" value="'.$data->sorteio_cartela_preco.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indice da rodada</label>
                            <input type="text" class="form-control" name="sorteio_indice_rodada" value="'.$data->sorteio_indice_rodada.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indice do giro</label>
                            <input type="text" class="form-control" name="sorteio_indice_giro" value="'.$data->sorteio_indice_giro.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indetificação do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_identificador" value="'.$data->sorteio_identificador.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Orgão de processo</label>
                            <input type="text" class="form-control" name="sorteio_processo_orgao" value="'.$data->sorteio_processo_orgao.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Numero do processo</label>
                            <input type="text" class="form-control" name="sorteio_processo_numero" value="'.$data->sorteio_processo_numero.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Valor do prêmio por rodada</label>
                            <input type="text" class="form-control" name="sorteio_premio_rodada_valor" value="'.$data->sorteio_premio_rodada_valor.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Nome da rodada</label>
                            <input type="text" class="form-control" name="sorteio_premio_rodada_nome" value="'.$data->sorteio_premio_rodada_nome.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Valor do prêmio por giro</label>
                            <input type="text" class="form-control" name="sorteio_premio_giro_valor" value="'.$data->sorteio_quantidade_giros.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Nome do giro</label>
                            <input type="text" class="form-control" name="sorteio_premio_giro_nome" value="'.$data->sorteio_premio_giro_nome.'" required>
                        </div>


                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Alterar</button>
                            
                    </form>
                
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
            <a href="#delete-'.$data->sala_id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-'.$data->sala_id.'">Excluir</a>
            <div class="modal fade" id="delete-'.$data->sala_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                  </div>
                  <div class="modal-body">
                    <span>Código: '.$data->sala_id.'</span><br>
                    <span>Login: '.$data->sala_nome.'</span>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('sweepstakes.destroy', ['sweepstake' => $data->sala_id]).'" method="POST">
                      <input type="hidden" name="_method" value="DELETE">
                      '.csrf_field().'
                      <input type="hidden" name="id" value="'.$data->sala_id.'">
                      <button type="submit" class="btn btn-danger">Excluir</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  </div>
                </div>
              </div>
            </div>';
        });

        return $dt->make(true);
    }

    public function destroy($user_id){
      try{
        $data = Sorteios::find($user_id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

    function statusToHtml($data, $id){
      $html = '';
      foreach($data as $d){
        $html .= '<option value="'.$d->cliente_id.'" '.($id == $d->cliente_id ? "selected": "").'>'.$d->cliente_nome.'</option>';
      }
      return $html;
    }
    
    public function getClienteNameById($data, $id){
      foreach ($data as $d){
          if($d->cliente_id == $id){
              return $d->cliente_id .' - '.$d->cliente_nome;
          }
      }
      return null;
    }

    public function getSalaNameById($data, $id){
        foreach ($data as $d){
            if($d->sala_id == $id){
                return $d->sala_id .' - '.$d->sala_nome;
            }
        }
        return null;
      }
}
