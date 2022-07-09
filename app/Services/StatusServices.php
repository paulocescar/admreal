<?php
namespace App\Services;

use App\Repositories\StatusRepository;

class StatusServices implements StatusServicesInterface{
    private $statusRepository;

    public function __construct(StatusRepository $statusRepository){
        $this->statusRepository = $statusRepository;
    }

    public function get(){
        return $this->statusRepository->get();
    }
}