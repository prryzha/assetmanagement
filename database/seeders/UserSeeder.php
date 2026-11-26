<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kepala Sekolah',
                'username' => 'admin',
                'email' => 'admin@smkn4bdg.sch.id',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Staf Sarpras',
                'username' => 'staf.sarpras',
                'email' => 'sarpras@smkn4bdg.sch.id',
                'role' => User::ROLE_STAFF,
            ],
            [
                'name' => 'Staf TU',
                'username' => 'staf.tu',
                'email' => 'tu@smkn4bdg.sch.id',
                'role' => User::ROLE_STAFF,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
