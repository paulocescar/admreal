<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PermissionsUsersRequest;
use App\Services\PermissionsUsersServices;
use App\Services\UserServices;

class PermissionsUsersController extends Controller
{
    private $permissionsUsersService, $userServices, $statusServices;

    public function __construct(
        PermissionsUsersServices $permissionsUsersService,
        UserServices $userServices
    ){
        $this->permissionsUsersService = $permissionsUsersService;
        $this->userServices = $userServices;
    }

    public function index()
    {
        $users = $this->userServices->get();
        $permissions = $this->permissionsUsersService->getPermissions();
        return view('panel.permissions.permission_users', compact('users','permissions'));
    }

    public function data()
    {
        $data = $this->permissionsUsersService->index();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsUsersRequest $request)
    {
        $this->permissionsUsersService->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->permissionsUsersService->update($request);
        return back()->with('success','Atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->permissionsUsersService->delete($request->input('usuario_id'), $request->input('permission_id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
