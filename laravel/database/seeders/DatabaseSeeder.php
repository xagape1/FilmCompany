<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Llama a las otras seeders desde aquí
        $this->call([
            UserSeeder::class,
            GenreSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
