<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = (string)substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,6);
        $senha = bcrypt(rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9));
        User::create([
            'name' => $user,
            'email' => $user.'@gmail.com',
            'password' => $senha
        ]);
    }
}
