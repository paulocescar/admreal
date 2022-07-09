<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SorteiosServices;
use App\Services\SalasServices;
use App\Services\ClientesServices;

class SorteiosController extends Controller
{
    private $salasServices, $clientesServices, $sorteiosServices;
    
    public function __construct(
        SorteiosServices $sorteiosServices,
        SalasServices $salasServices,
        ClientesServices $clientesServices
    ){
        $this->sorteiosServices = $sorteiosServices;
        $this->salasServices = $salasServices;
        $this->clientesServices = $clientesServices;
    }
    public function index()
    {
        $clientes = $this->clientesServices->get();
        $salas = $this->salasServices->get();
        return view('panel.sorteios.sorteios', compact(['clientes','salas']));
    }

    public function store(Request $request)
    {
        $this->sorteiosServices->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    public function data(){
        $data = $this->sorteiosServices->index();
        return $data;
    }

    public function update(Request $request){
        $this->sorteiosServices->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }
    
    public function destroy(Request $request){
        $this->sorteiosServices->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
