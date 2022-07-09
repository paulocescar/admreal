<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Clientes;
use Datatables;

/**
 * Class ClientesRepository.
 */
class ClientesRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Clientes::class;
    }


    public function index(){
        
        $data = Clientes::select(array(
            'clientes.cliente_id',
            'clientes.cliente_nome', 
            'clientes.cliente_cnpj', 
            'clientes.cliente_comissao', 
            'clientes.d_ins'))->orderBy('clientes.cliente_id','DESC');
        
        $dt = Datatables::of($data);

        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';
        })->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->cliente_id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->cliente_id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->cliente_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('clients.update', ['client' => $data->cliente_id]).'" method="post">
                    <div class="container">
                        '.csrf_field().'
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="'.$data->cliente_id.'">
      
                        <div class="form-group">
                            <label for"nome">Nome</label>
                            <input type="text" class="form-control" name="cliente_nome" value="'.$data->cliente_nome.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">CNPJ</label>
                            <input type="text" class="form-control" name="cliente_cnpj" value="'.$data->cliente_cnpj.'" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Comissao</label>
                            <input type="number" step="0.1" class="form-control" name="cliente_comissao" value="'.$data->cliente_comissao.'" required>
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
            <a href="#delete-'.$data->cliente_id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-'.$data->cliente_id.'">Excluir</a>
            <div class="modal fade" id="delete-'.$data->cliente_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                  </div>
                  <div class="modal-body">
                    <span>Código: '.$data->cliente_id.'</span><br>
                    <span>Login: '.$data->cliente_nome.'</span>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('clients.destroy', ['client' => $data->cliente_id]).'" method="POST">
                      <input type="hidden" name="_method" value="DELETE">
                      '.csrf_field().'
                      <input type="hidden" name="id" value="'.$data->cliente_id.'">
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
        $data = Clientes::find($user_id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }
}
