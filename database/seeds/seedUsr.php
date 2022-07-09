<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class seedUsr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i <= 50; $i++) {
            $user = (string)substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0,6);
            $senha = bcrypt(rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9)."".rand(0, 9));
            $email = $this->emailDePara(rand(0, 5));
            User::create([
                'name' => $user,
                'email' => $user.'@'.$email,
                'password' => $senha
            ]); 
        }
    }

    public function emailDePara($i){
        switch($i){
            case 0:
                return "bol.com.br";
            case 1:
                return "gmail.com";
            case 2:
                return "hotmail.com";
            case 3:
                return "outlook.com";
            case 4:
                return "live.com";
            default:
                return 'email.com';
        }
    }
}
