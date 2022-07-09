<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Salas;
use App\Models\Clientes;
use Datatables;

/**
 * Class SalasRepository.
 */
class SalasRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Salas::class;
    }


    public function index(){
        
        $data = Salas::select(array(
            'salas.cliente_id',
            'salas.sala_id', 
            'salas.sala_nome', 
            'salas.sala_endereco_logradouro', 
            'salas.sala_endereco_numero',
            'salas.sala_endereco_complemento', 
            'salas.sala_endereco_cep', 
            'salas.sala_endereco_cidade', 
            'salas.sala_endereco_uf',
            'salas.sala_endereco_gps', 
            'salas.sala_endereco_horario',
            'salas.d_ins'))->orderBy('salas.sala_id','DESC');
        
        $dt = Datatables::of($data);

        $clientes = Clientes::get();
        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';
        })->editColumn('cliente_id', function ($data) use($clientes) {
          return $data->cliente_id ? $this->getClienteNameById($clientes, $data->cliente_id) : '';
        })->addColumn('action', function ($data) use($clientes) {
            return '<a href="#edit-'.$data->sala_id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->sala_id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->sala_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('rooms.update', ['room' => $data->sala_id]).'" method="post">
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
                            <label for"nome">Nome da sala</label>
                            <input type="text" class="form-control" name="sala_nome" value="'.$data->sala_nome.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Logradouro</label>
                            <input type="text" class="form-control" name="sala_endereco_logradouro" value="'.$data->sala_endereco_logradouro.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Numero</label>
                            <input type="text" class="form-control" name="sala_endereco_numero" value="'.$data->sala_endereco_numero.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Complemento</label>
                            <input type="text" class="form-control" name="sala_endereco_complemento" value="'.$data->sala_endereco_complemento.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">CEP</label>
                            <input type="text" class="form-control" name="sala_endereco_cep" value="'.$data->sala_endereco_cep.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Cidade</label>
                            <input type="text" class="form-control" name="sala_endereco_cidade" value="'.$data->sala_endereco_cidade.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">UF</label>
                            <input type="text" class="form-control" name="sala_endereco_uf" value="'.$data->sala_endereco_uf.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">GPS</label>
                            <input type="text" class="form-control" name="sala_endereco_gps" value="'.$data->sala_endereco_gps.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Horário</label>
                            <input type="text" class="form-control" name="sala_endereco_horario" value="'.$data->sala_endereco_horario.'" required>
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
                    <form action="'.Route('rooms.destroy', ['room' => $data->sala_id]).'" method="POST">
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
        $data = Salas::find($user_id)->delete();
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

}
