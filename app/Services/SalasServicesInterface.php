<?php
namespace App\Services;

interface SalasServicesInterface {
    public function index();
    public function get();
    public function create($data);
    public function update($data);
    public function delete($sala_id);
}