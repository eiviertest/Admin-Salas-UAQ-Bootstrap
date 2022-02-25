<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => "Admin"]);
        $roleUser = Role::create(['name' => "User"]);
        
        //Permisos Admin
        Permission::create(['name' => 'Admin_Home'])->assignRole($roleAdmin);
        Permission::create(['name' => 'Admin_Reportes'])->assignRole($roleAdmin);
        Permission::create(['name' => 'Admin_Cursos'])->assignRole($roleAdmin);
        Permission::create(['name' => 'Admin_Cursos_Crear'])->assignRole($roleAdmin);
        Permission::create(['name' => 'Admin_Solicitudes'])->assignRole($roleAdmin);

        //Permisos User
        Permission::create(['name' => 'User_Home'])->assignRole($roleUser);
        Permission::create(['name' => 'User_Cursos'])->assignRole($roleUser);
        Permission::create(['name' => 'User_Salas_Solicitar'])->assignRole($roleUser);
        Permission::create(['name' => 'User_Solicitudes_Ver'])->assignRole($roleUser); 
    }
}
