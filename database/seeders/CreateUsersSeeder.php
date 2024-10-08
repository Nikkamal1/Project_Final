<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'is_admin' => 1,
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'is_admin' => 0,
                'password' => bcrypt('1234')
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@example.com',
                'is_admin' => 2,
                'password' => bcrypt('1234')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
