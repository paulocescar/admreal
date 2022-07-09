<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClientesServices;

class ClientesController extends Controller
{
    private $clientesServices;
    
    public function __construct(
        ClientesServices $clientesServices
    ){
        $this->clientesServices = $clientesServices;
    }
    public function index()
    {
        return view('panel.clientes.clientes');
    }

    public function store(Request $request)
    {
        $this->clientesServices->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    public function data(){
        $data = $this->clientesServices->index();
        return $data;
    }

    public function update(Request $request){
        $this->clientesServices->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }
    
    public function destroy(Request $request){
        $this->clientesServices->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
