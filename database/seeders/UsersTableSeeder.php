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


        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@url-shortener.com',
            'password' => Hash::make('secret'),
            'role_id' => 1,
        ]);

        Wallet::insert([
            [
                'user_id' => 0,
            ],
            [
                'user_id' => $user->id,
            ]
        ]);
    }
}
