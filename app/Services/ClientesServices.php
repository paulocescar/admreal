<?php
namespace App\Services;

use App\Repositories\ClientesRepository;

class ClientesServices implements ClientesServicesInterface{
    
    private $clientesRepository;
    
    public function __construct(
        ClientesRepository $clientesRepository
    ){
        $this->clientesRepository = $clientesRepository;
    }

    public function index(){
        $data = $this->clientesRepository->index();
        return $data;
    }

    public function get(){
        return $this->clientesRepository->get();
    }

    public function create($data){
        try{
            $created = $this->clientesRepository->create($data->all());
            return $created;
        }catch(Exception $e){
            return $e->message();
        }
    }
    public function update($data){
        try{
            $updated = $this->clientesRepository->updateById($data->id, $data->all());
            return $updated;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($id){
        $data = $this->clientesRepository->destroy($id);
        return $data;
    }
}