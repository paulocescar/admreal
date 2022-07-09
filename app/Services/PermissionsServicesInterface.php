<?php 
namespace App\Services;

interface PermissionsServicesInterface{
    public function index();
    public function getPermissions();
    public function create($data);
    public function update($data);
    public function delete($permission_id);
}