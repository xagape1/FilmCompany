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

        Permission::create(['name' => 'series.*']);
        Permission::create(['name' => 'series.list']);
        Permission::create(['name' => 'series.create']);
        Permission::create(['name' => 'series.update']);
        Permission::create(['name' => 'series.read']);
        Permission::create(['name' => 'series.delete']);

        Permission::create(['name' => 'seasons.*']);
        Permission::create(['name' => 'seasons.list']);
        Permission::create(['name' => 'seasons.create']);
        Permission::create(['name' => 'seasons.update']);
        Permission::create(['name' => 'seasons.read']);
        Permission::create(['name' => 'seasons.delete']);

        Permission::create(['name' => 'episodes.*']);
        Permission::create(['name' => 'episodes.list']);
        Permission::create(['name' => 'episodes.create']);
        Permission::create(['name' => 'episodes.update']);
        Permission::create(['name' => 'episodes.read']);
        Permission::create(['name' => 'episodes.delete']);

        $adminRole->givePermissionTo(['movies.*','series.*','seasons.*','episodes.*' ]);
        $newRole->givePermissionTo(['']);
        $payRole->givePermissionTo(['movies.list','movies.read','seasons.list','seasons.read','episodes.list','episodes.read' ]);

        $user = User::find(1);


        if ($user) {
            $user->assignRole($adminRole);
        } else { echo "Usuario no encontrado.";
        }



    }
}