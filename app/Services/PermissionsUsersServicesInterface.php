<?php 
namespace App\Services;

interface PermissionsUsersServicesInterface{
    public function index();
    public function getPermissions();
    public function create($data);
    public function update($data);
    public function delete($user_id, $permission_id);
}