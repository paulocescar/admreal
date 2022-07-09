<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Permission_user;
use App\Models\Permission;
use App\Models\User;
use App\Models\Statuses;
use Datatables;
use DB;

/**
 * Class PermissionsRepository.
 */
class PermissionsUsersRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Permission_user::class;
    }

    
    public function index(){
        
        $data = DB::table('permission_user')->select(array('permission_user.permission_id','permission_user.usuario_id','permission_user.user_type'))->orderBy('permission_id','DESC');
        
        $dt = Datatables::of($data);

        $permission = Permission::get();
        $users = User::get();
        $dt->editColumn('permission_id', function($data) use($permission) {
            return $data->permission_id ? $data->permission_id." - ".$this->getNameById($permission, $data->permission_id)->description : $data->permission_id;
        })->editColumn('usuario_id', function($data) use($users){
            return $data->usuario_id ? $data->usuario_id." - ".$this->getUserNameById($users, $data->usuario_id)->usuario_login : $data->usuario_id;
        })->addColumn('action', function ($data) {
            return '<a href="#edit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit" onClick="setEditFields('.$data->usuario_id.','.$data->permission_id.')">Editar</a>
            
            <a href="#delete-'.$data->permission_id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-'.$data->permission_id.'">Excluir</a>
            <div class="modal fade" id="delete-'.$data->permission_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja Excluir?</h5>
                  </div>
                  <div class="modal-body">
                    <span>Código da permissão: '.$data->permission_id.'</span><br>
                    <span>Usuário: '.$data->usuario_id.'</span>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('permission_users.destroy', ['permission_user' => $data->permission_id]).'" method="POST">
                      <input type="hidden" name="_method" value="DELETE">
                      '.csrf_field().'
                      <input type="hidden" name="usuario_id" value="'.$data->usuario_id.'">
                      <input type="hidden" name="permission_id" value="'.$data->permission_id.'">
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

    public function addWhere($data){
      $exist_puser = DB::table('permission_user')->where('usuario_id',$data->usuario_id)->where('permission_id',$data->permission_id)->first();
      if($exist_puser){ return false; }

      try{
        $datapUser = $data->only(['usuario_id','permission_id']);
        $datapUser['user_type'] = 'App\Models\User';
        $pUser = DB::table('permission_user')->insert($datapUser);
        return $pUser;
      }catch(Exception $e){
        return $e->message();
      }
    }

    public function destroy($usuario_id, $permission_id){
      try{
        $data = DB::table('permission_user')->where('usuario_id',$usuario_id)->where('permission_id',$permission_id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

    public function getPermissions(){
        $data = DB::table('permissions')->get();
        return $data;
    }

    public function updateByWheres($data){
      $pUser = DB::table('permission_user')->where('user_id',$data->user_id_old)->where('permission_id',$data->permission_id_old)
      ->update(['user_id' => $data->user_id, 'permission_id' => $data->permission_id]);
      return $pUser;
    }

    /**
     * Get All Status
     */
    function statusToHtml($data, $status_id){
      $html = '';
      foreach($data as $d){
        $html .= '<option value="'.$d->id.'" '.($status_id == $d->id ? "selected": "").'>'.$d->name.'</option>';
      }
      return $html;
    }

    public function getUserNameById($data, $id){
      foreach ($data as $d){
          if($d->usuario_id == $id){
              return $d;
          }
      }
      return null;
    }

    
    public function getNameById($data, $id){
      foreach ($data as $d){
          if($d->id == $id){
              return $d;
          }
      }
      return null;
    }

}
