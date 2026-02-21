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
        $password = 'abcd1234';
        if(app()->environment('production')) {
            $password = Str::random();
        }
        User::create([
            'username' => 'admin',
            'password' => Hash::make($password),
            'is_admin' => true,
            'activated_at' => now(),
        ]);
        $this->command->info('Admin user created with password: ' . $password);
    }
}
