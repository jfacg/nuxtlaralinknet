<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jailson Ferreira',
            'email' => 'jailson.pb@gmail.com',
            'password' => bcrypt('123456'),
        ])->roles()->sync(1);
    }
}
