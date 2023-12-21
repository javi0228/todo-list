<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            "name" => "javi",
            "email" => "javirodriguezbnk@gmail.com",
            'password' => bcrypt('28febrero'),
        ]);

        $admin->syncRoles(['admin']);

        // Worker users
        User::factory(10)->create();

    }
}
