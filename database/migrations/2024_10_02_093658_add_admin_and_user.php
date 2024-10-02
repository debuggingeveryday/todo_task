<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public const ADMIN_USER = [
        'name' => 'admin',
        'email' => 'admin@system.com',
        'user_type' => User::ADMIN_USER,
    ];

    public const ADMIN_DETAILS = [
        'first_name' => 'admin',
        'last_name' => 'system',
    ];

    public const STAFF_USER = [
        'name' => 'staff',
        'email' => 'staff@system.com',
        'user_type' => User::STAFF_USER,
    ];

    public const STAFF_DETAILS = [
        'first_name' => 'staff',
        'last_name' => 'system',
    ];

    public function up(): void
    {

        if (App::environment('local') || App::environment('dev')) {
            $admin_user = User::create([
                ...self::ADMIN_USER,
                'password' => Hash::make('admin12345')
            ]);

            UserDetails::create([
                ...self::ADMIN_DETAILS,
                'user_id' => $admin_user->id
            ]);

            $staff_user = User::create([
                ...self::STAFF_USER,
                'password' => Hash::make('staff12345')
            ]);

            UserDetails::create([
                ...self::STAFF_DETAILS,
                'user_id' => $staff_user->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (App::environment('local') || App::environment('dev')) {
            $admin_user = User::where(self::ADMIN_USER)->firstOrFail();
            $admin_user->userDetails->delete();
            $admin_user->delete();

            $staff_user = User::where(self::STAFF_USER)->firstOrFail();
            $staff_user->userDetails->delete();
            $staff_user->delete();
        }
    }
};
