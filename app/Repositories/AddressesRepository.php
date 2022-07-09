<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Addresses;
use App\Models\Statuses;
use Datatables;

/**
 * Class OutletsRepository.
 */
class AddressesRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Addresses::class;
    }

    
    public function index(){
        
        $data = Addresses::select(array('addresses.id',
                    'addresses.name',
                    'addresses.email',
                    'addresses.cnpj',
                    'addresses.cpf',
                    'addresses.status_id'))->orderBy('id','DESC');
        
        $dt = Datatables::of($data);
        $status = Statuses::get();

        $dt->editColumn('status_id', function ($data) use($status) {
            return $data->status_id ? $this->getNameById($status, $data->status_id)->name : '';
        })->addColumn('action', function ($data) use($status) {
            return '<a href="#edit-'.$data->id.'" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit-'.$data->id.'">Editar</a>
            <div class="modal fade" id="edit-'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                  </div>
                    <form action="'.Route('categories.update', ['category' => $data->id]).'" method="post">
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
                            <label for"nome">Descrição</label>
                            <Textarea name="description" class="form-control" rows="3">'.$data->description.'</Textarea>
                        </div>

                        <div class="form-group">
                            <label for"nome">Status</label>
                            <select class="form-control" name="status_id" required>'.$this->statusToHtml($status, $data->status_id).'</select>
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
                    <form action="'.Route('categories.destroy', ['category' => $data->id]).'" method="POST">
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

    public function destroy($id){
      try{
        $data = Addresses::find($id)->delete();
        return $data;
      }catch(Exception $e){
        return $e->message();
      }
    }

    function statusToHtml($data, $id){
      $html = '';
      foreach($data as $d){
        $html .= '<option value="'.$d->id.'" '.($id == $d->id ? "selected": "").'>'.$d->name.'</option>';
      }
      return $html;
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
