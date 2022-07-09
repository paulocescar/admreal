<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamsServices;
use App\Services\StatusServices;
use App\Http\Requests\TeamRequest;

class TeamsController extends Controller
{
    private $teamsServices, $statusServices;

    public function __construct(
        TeamsServices $teamsServices,
        StatusServices $statusServices
    ){
        $this->teamsServices = $teamsServices;
        $this->statusServices = $statusServices;
    }

    public function index(){
        $status = $this->statusServices->get();
        return view('panel.teams.teams', compact('status'));
    }

    public function data(){
        $data = $this->teamsServices->index();
        return $data;
    }

    public function store(TeamRequest $request){
        $this->teamsServices->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    public function update(TeamRequest $request){
        $data = $this->teamsServices->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }
    
    
    public function destroy(Request $request){
        $this->teamsServices->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
