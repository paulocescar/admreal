<?php
namespace App\Services;

use App\Repositories\UserRepository;

class UserServices implements UserServicesInterface{
    
    private $userRepository;
    
    public function __construct(
        UserRepository $userRepository
    ){
        $this->userRepository = $userRepository;
    }

    public function index(){
        $data = $this->userRepository->index();
        return $data;
    }

    public function findByLogin($login){
        return $this->userRepository->findByLogin($login);
    }

    public function get(){
        return $this->userRepository->get();
    }

    public function create($data){
        try{
            $dados = $data->all();
            $dados['usuario_senha'] = md5($data->usuario_senha);
            $created = $this->userRepository->create($dados);
            return $created;
        }catch(Exception $e){
            return $e->message();
        }
    }
    public function update($data){
        try{
            $dados = $data->all();
            $dados['usuario_senha'] = md5($data->usuario_senha);
            $data = $this->userRepository->updateById($data->id, $dados);
            return $data;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($user_id){
        $data = $this->userRepository->destroy($user_id);
        return $data;
    }
}