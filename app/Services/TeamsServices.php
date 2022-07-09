<?php
namespace App\Services;

use App\Repositories\TeamsRepository;

class TeamsServices implements TeamsServicesInterface {
    private $teamsRepository;

    public function __construct(TeamsRepository $teamsRepository)
    {
        $this->teamsRepository = $teamsRepository;
    }

    public function index(){
        $data = $this->teamsRepository->index();
        return $data;
    }
    public function create($data){
        try{
            $data = $this->teamsRepository->create($data->all());
            return $data;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function update($data){
        try{
            $data = $this->teamsRepository->updateById($data->id,$data->all());
            return $data;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($team_id){
        $data = $this->teamsRepository->destroy($team_id);
        return $data;
    }
}