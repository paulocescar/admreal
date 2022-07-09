<?php

use Illuminate\Database\Seeder;
use App\Models\Statuses;

class seedStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Statuses::create(['name' => 'Ativado']);
        Statuses::create(['name' => 'Desativado']);
        Statuses::create(['name' => 'Concluido']);
        Statuses::create(['name' => 'Pendente']);
        Statuses::create(['name' => 'Cancelado']);
    }
}
