<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PermissionsRequest;
use App\Services\PermissionsServices;
use App\Services\UserServices;

class PermissionsController extends Controller
{
    private $permissionsService, $userServices;

    public function __construct(
        PermissionsServices $permissionsService,
        UserServices $userServices
    ){
        $this->permissionsService = $permissionsService;
        $this->userServices = $userServices;
    }

    public function index()
    {
        $users = $this->userServices->get();
        $permissions = $this->permissionsService->getPermissions();
        return view('panel.permissions.permissions', compact('users','permissions'));
    }

    public function data()
    {
        $data = $this->permissionsService->index();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionsRequest $request)
    {
        $this->permissionsService->create($request);
        return back()->with('success','Criado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionsRequest $request)
    {
        $this->permissionsService->update($request);
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
        $this->permissionsService->delete($request->input('id'));
        return back()->with('success','Deletado com sucesso.');
    }
}
