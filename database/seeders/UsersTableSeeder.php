<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        Wallet::truncate();


        $user = User::insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@url-shortener.com',
                'password' => Hash::make('secret'),
                'role_id' => 1,
            ],
            [
                'name' => 'Jonh Doe',
                'username' => 'jonhdoe',
                'email' => 'jonhdoe@url-shortener.com',
                'password' => Hash::make('secret'),
                'role_id' => 3,
            ],
            [
                'name' => 'Moderator',
                'username' => 'moderator',
                'email' => 'moderator@url-shortener.com',
                'password' => Hash::make('secret'),
                'role_id' => 3,
            ]
        ]);

        Wallet::insert([
            [
                'user_id' => 0,
                'available_balance' => 0.0000,
            ],
            [
                'user_id' => 1,
                'available_balance' => 10.0000,
            ],
            [
                'user_id' => 2,
                'available_balance' => 8.0000,
            ],
            [
                'user_id' => 3,
                'available_balance' => 12.0000,
            ]
        ]);
    }
}
