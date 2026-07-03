<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Existing user seeder
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'ipdayu@gmail.com',
            'password' => bcrypt('BrajaAsri@24'),
        ]);

        // Seed initial links
        $this->call(LinkSeeder::class);
    }
}
