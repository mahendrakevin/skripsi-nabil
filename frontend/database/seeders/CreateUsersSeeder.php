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
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@raalfalah.com',
                'role' => '1',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@raalfalah.com',
                'role' => '2',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@raalfalah.com',
                'role' => '3',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
