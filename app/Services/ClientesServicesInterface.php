<?php
namespace App\Services;

interface ClientesServicesInterface {
    public function index();
    public function get();
    public function create($data);
    public function update($data);
    public function delete($id);
}