<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $is_prod = app()->environment('production');
        $password = 'abcd1234';
        if($is_prod) {
            $password = Str::random();
        }
        User::create([
            'username' => 'admin',
            'password' => Hash::make($password),
            'is_admin' => true,
            'activated_at' => now(),
        ]);
        $this->command->info('Admin user created with password: ' . $password);

        if(!$is_prod) {
            $this->command->info('Creating 100 regular users...');
            User::factory()->createMany(100);
            $this->command->info('100 regular users created');
        }
    }
}
