<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sergi = new User();
        $sergi->name = "Sergi Boquera";
        $sergi->email = "sergibofu@gmail.com";
        $sergi->password = Hash::make("password1234");
        $sergi->save();

        $manel = new User();
        $manel->name = "Manel Aaa";
        $manel->email = "ManeA@gmail.com";
        $manel->password = Hash::make("password1234");
        $manel->save();

        User::factory(30)->create();
    }
}
