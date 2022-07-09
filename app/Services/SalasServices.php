<?php
namespace App\Services;

use App\Repositories\SalasRepository;

class SalasServices implements SalasServicesInterface{
    
    private $salasRepository;
    
    public function __construct(
        SalasRepository $salasRepository
    ){
        $this->salasRepository = $salasRepository;
    }

    public function index(){
        $data = $this->salasRepository->index();
        return $data;
    }

    public function get(){
        return $this->salasRepository->get();
    }

    public function create($data){
        try{
            $created = $this->salasRepository->create($data->all());
            return $created;
        }catch(Exception $e){
            return $e->message();
        }
    }
    public function update($data){
        try{
            $updated = $this->salasRepository->updateById($data->id, $data->all());
            return $updated;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($sala_id){
        $data = $this->salasRepository->destroy($sala_id);
        return $data;
    }
}