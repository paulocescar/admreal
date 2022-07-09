<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StatusServices;

class StatusController extends Controller
{
    private $statusServices;

    public function __construct(StatusServices $statusServices){
        $this->statusServices = $statusServices;
    }

    public function index(){
        return $this->statusServices->get();
    }
}
