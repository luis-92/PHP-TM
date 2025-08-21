<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Use an env var in real environments; fallback to 'password' for dev
        $plain = env('ADMIN_SEED_PASSWORD', 'password');

        /** @var \App\Models\User $user */
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make($plain),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),

                // If you use an is_admin boolean:
                // 'is_admin' => true,
            ]
        );

        // If you use Spatie Permission:
        // if (method_exists($user, 'assignRole')) {
        //     $user->assignRole('SuperAdmin');
        // }

        $this->command?->info("Admin user ready: {$user->email} (password: {$plain})");
    }
}
