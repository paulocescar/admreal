<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $userServices;
    
    public function __construct(
        UserServices $userServices
    ){
        $this->userServices = $userServices;
    }

    
    public function login(Request $request)
    {
        $user = $this->userServices->findByLogin($request->login);
        if($user){
            if(md5($request->password) == $user->usuario_senha){
                Auth::loginUsingId($user->usuario_id);
                return redirect()->route('home');
            }else{
                return back()->with('error','E-mail ou senha inválido');
            }
        }else{
            return back()->with('error','E-mail ou senha inválido');
        }
    }

    public function index()
    {
        return view('panel.users.users');
    }

    public function store(Request $request)
    {
        $this->userServices->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    public function data(){
        $data = $this->userServices->index();
        return $data;
    }

    public function profile(){
        return view('panel.users.profile');
    }

    public function update(Request $request){
        $data = $this->userServices->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }
    
    public function destroy(Request $request){
        $this->userServices->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
