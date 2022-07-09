<?php
namespace App\Services;

Interface TeamsServicesInterface {
    public function index();
    public function create($data);
    public function update($data);
    public function delete($team_id);
}