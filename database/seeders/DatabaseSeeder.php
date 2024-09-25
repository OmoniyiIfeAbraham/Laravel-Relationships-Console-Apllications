<?php

namespace Database\Seeders;

use App\Models\PasswordModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // create 50 users
        UserModel::factory()->count(50)->create()->each(function ($user) {
            // for each user create 5 passwords
            PasswordModel::factory()->count(5)->create(['user_id' => $user->id]);
        });
    }
}
