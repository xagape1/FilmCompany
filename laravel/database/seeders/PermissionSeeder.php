<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $newRole = Role::create(['name' => 'new']);
        $payRole = Role::create(['name' => 'pay']);

        Permission::create(['name' => 'movies.*']);
        Permission::create(['name' => 'movies.list']);
        Permission::create(['name' => 'movies.create']);
        Permission::create(['name' => 'movies.update']);
        Permission::create(['name' => 'movies.read']);
        Permission::create(['name' => 'movies.delete']);

        $adminRole->givePermissionTo(['movies.*']);
        $newRole->givePermissionTo(['']);
        $payRole->givePermissionTo(['movies.list','movies.read']);

        $user = User::find(1);
        $user2 = User::find(2);

        if ($user) {
            $user->assignRole($adminRole);
        } else { echo "Usuario no encontrado.";
        }

        if ($user2) {
            $user2->assignRole($payRole);
        } else {  echo "Usuario no encontrado.";
        }

    }
}