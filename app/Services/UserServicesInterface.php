<?php
namespace App\Services;

interface UserServicesInterface {
    public function index();
    public function get();
    public function findByLogin($login);
    public function create($data);
    public function update($data);
    public function delete($user_id);
}