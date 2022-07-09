<?php 
namespace App\Services;

use App\Repositories\PermissionsRepository;

class PermissionsServices implements PermissionsServicesInterface{
    private $permissionsRepository;

    public function __construct(PermissionsRepository $permissionsRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
    }

    public function index(){
        return $this->permissionsRepository->index();
    }

    public function getPermissions(){
        return $this->permissionsRepository->getPermissions();
    }

    public function create($data){
        try{
            $data = $this->permissionsRepository->create($data->all());
            return $data;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function update($data){
        try{
            $data = $this->permissionsRepository->updateById($data->id,$data->all());
            return $data;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($permission_id){
        $data = $this->permissionsRepository->destroy($permission_id);
        return $data;
    }
}