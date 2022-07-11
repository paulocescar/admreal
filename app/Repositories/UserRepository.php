<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;
use Datatables;

/**
 * Class UserRepository.
 */
class UserRepository extends Src\JasonGuru\LaravelMakeRepository\Repository\BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function findByLogin($login){
      try{
        $data = User::where('usuario_login',$login)->first();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

    public function index(){
        
        $data = User::select(array('usuarios.usuario_id','usuarios.usuario_nome','usuarios.usuario_login','usuarios.d_ins'))->orderBy('usuario_id','DESC');
        
        $dt = Datatables::of($data);

        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';
        })->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('users.update', ['user' => $data->usuario_id]).'" method="post">
                    <div class="container">
                        '.csrf_field().'
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="'.$data->usuario_id.'">
      
                        <div class="form-group">
                            <label for"nome">Name</label>
                            <input type="text" class="form-control" name="email" value="'.$data->usuario_nome.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Login</label>
                            <input type="text" class="form-control" name="email" value="'.$data->usuario_login.'" required>
                        </div>

                        
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <div class="form-group">
                                    <label for"nome">Senha</label>
                                    <input type="password" class="form-control" name="password" value="" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-6">
                                <div class="form-group">
                                    <label for"nome">Confirmação de senha</label>
                                    <input type="password" class="form-control" name="passwordConfirm" value="" required>
                                </div>
                            </div>
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
            <a href="#delete-'.$data->usuario_id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-'.$data->usuario_id.'">Excluir</a>
            <div class="modal fade" id="delete-'.$data->usuario_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                  </div>
                  <div class="modal-body">
                    <span>Código: '.$data->usuario_id.'</span><br>
                    <span>Login: '.$data->usuario_login.'</span>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('users.destroy', ['user' => $data->usuario_id]).'" method="POST">
                      <input type="hidden" name="_method" value="DELETE">
                      '.csrf_field().'
                      <input type="hidden" name="id" value="'.$data->usuario_id.'">
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
        $data = User::find($user_id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }
}
