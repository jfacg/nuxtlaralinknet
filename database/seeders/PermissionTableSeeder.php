<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'admin',
            'description' => 'Modulos Usuários, Funções, Permissões',
        ]);
        Permission::create([
            'name' => 'project',
            'description' => 'Modulos Projetos',
        ]);
    }
}
