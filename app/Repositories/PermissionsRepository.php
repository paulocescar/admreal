<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Permission_user;
use App\Models\Permission;
use App\Models\User;
use Datatables;
use DB;

/**
 * Class PermissionsRepository.
 */
class PermissionsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Permission::class;
    }

    
    public function index(){
        
        $data = Permission::select(array('permissions.id','permissions.name','permissions.display_name','permissions.description'))->orderBy('id','DESC');
        
        $dt = Datatables::of($data);

        $dt->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('permissions.update', ['permission' => $data->id]).'" method="post">
                    <div class="container">
                        '.csrf_field().'
                        <br><label>Código: '.$data->id.'</label><br>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="'.$data->id.'">
      
                        <div class="form-group">
                            <label for"nome">Nome</label>
                            <input type="text" class="form-control" name="name" value="'.$data->name.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Nome de exibição</label>
                            <input type="text" class="form-control" name="display_name" value="'.$data->display_name.'" required>
                        </div>
                        
                        <div class="form-group">
                            <label for"nome">Descrição</label>
                            <Textarea name="description" class="form-control" rows="3">'.$data->description.'</Textarea>
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
            <a href="#delete-'.$data->id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-'.$data->id.'">Excluir</a>
            <div class="modal fade" id="delete-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                  </div>
                  <div class="modal-body">
                    <span>Código da permissão: '.$data->id.'</span><br>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('permissions.destroy', ['permission' => $data->id]).'" method="POST">
                      <input type="hidden" name="_method" value="DELETE">
                      '.csrf_field().'
                      <input type="hidden" name="id" value="'.$data->id.'">
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

    public function destroy($permission_id){
      try{
        $data = Permission::find($permission_id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

    public function getPermissions(){
        $data = Permission::get();
        return $data;
    }
}
