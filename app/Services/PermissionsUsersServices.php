<?php 
namespace App\Services;

use App\Repositories\PermissionsUsersRepository;

class PermissionsUsersServices implements PermissionsUsersServicesInterface{
    private $permissionsUsersRepository;

    public function __construct(PermissionsUsersRepository $permissionsUsersRepository)
    {
        $this->permissionsUsersRepository = $permissionsUsersRepository;
    }

    public function index(){
        return $this->permissionsUsersRepository->index();
    }

    public function getPermissions(){
        return $this->permissionsUsersRepository->getPermissions();
    }

    public function create($data){
        return $this->permissionsUsersRepository->addWhere($data);
    }

    public function update($data){
        try{
            $data = $this->permissionsUsersRepository->updateByWheres($data);
            return $data;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($user_id, $permission_id){
        return $this->permissionsUsersRepository->destroy($user_id, $permission_id);
    }
}