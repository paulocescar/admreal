<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Team;
use App\Models\Statuses;
use App\Services\StatusServices;
use Datatables;

/**
 * Class TeamsRepository.
 */
class TeamsRepository extends BaseRepository
{
    public function model()
    {
        return Team::class;
    }

    private $statusServices;

    public function __construct(StatusServices $statusServices)
    {
      $this->statusServices = $statusServices;
    }

    public function index(){
        $data = Team::select(array('teams.id','teams.name','teams.display_name','teams.description','teams.status_id','teams.created_at'))->orderBy('id','DESC');
        
        $dt = Datatables::of($data);

        $dt->editColumn('created_at', function ($data) {
            return $data->created_at ? with(new \Carbon\Carbon($data->created_at))->format('d/m/Y') : '';
        })->editColumn('status_id', function ($data){
          return $data->status_id ? Statuses::find($data->status_id)->name : '';
        })->addColumn('action', function ($data) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('teams.update', ['team' => $data->id]).'" method="post">
                    <div class="container">
                        '.csrf_field().'
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="'.$data->id.'">
      
                        <div class="form-group">
                            <label for"nome">Name</label>
                            <input type="text" class="form-control" name="name" value="'.$data->name.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Display Name</label>
                            <input type="text" class="form-control" name="display_name" value="'.$data->display_name.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Descrição</label>
                            <input type="text" class="form-control" name="descrption" value="'.$data->description.'" required>
                        </div>

                        <div class="form-group">
                            <label for"nome">Status</label>
                            <select class="form-control" name="status_id" required>'.$this->statusToHtml(Statuses::get(), $data->status_id).'</select>
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
                    <span>Código: '.$data->id.'</span><br>
                    <span>Name: '.$data->name.'</span>
                  </div>
                  <div class="modal-footer">
                    <form action="'.Route('teams.destroy', ['team' => $data->id]).'" method="POST">
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

    public function destroy($team_id){
      try{
        $data = Team::find($team_id)->forceDelete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

}
