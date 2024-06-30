<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'user_code' => Str::random(8),
            'user_name' => 'Tech.Support',
            'user_email' => 'support@yottaline.com',
            'user_password' => Hash::make('Support@Yottaline'),
            'user_created' => now()
        ]);
    }
}