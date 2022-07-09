<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalasServices;
use App\Services\ClientesServices;

class SalasController extends Controller
{
    private $salasServices, $clientesServices;
    
    public function __construct(
        SalasServices $salasServices,
        ClientesServices $clientesServices
    ){
        $this->salasServices = $salasServices;
        $this->clientesServices = $clientesServices;
    }
    public function index()
    {
        $clientes = $this->clientesServices->get();
        return view('panel.salas.salas', compact('clientes'));
    }

    public function store(Request $request)
    {
        $this->salasServices->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    public function data(){
        $data = $this->salasServices->index();
        return $data;
    }

    public function update(Request $request){
        $this->salasServices->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }
    
    public function destroy(Request $request){
        $this->salasServices->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
