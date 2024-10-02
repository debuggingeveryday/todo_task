<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Todo;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Todo::factory(100)->create();
    }
}
