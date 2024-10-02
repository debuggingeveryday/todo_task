<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Todo;
use Illuminate\Support\Facades\App;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (App::environment('local') || App::environment('dev')) {
            Todo::factory(100)->create();
        }
    }
}
