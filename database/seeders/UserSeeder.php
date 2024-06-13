<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create multiple users
        $user = [
            [
                'name' => 'Admin',
                'phone' => '085641173515',
                'email' => 'indraaadii04@gmail.com',
                'password' => bcrypt('Indraadikusuma54321'),
            ],
            [
                'name' => 'Admin',
                'phone' => '081548094408',
                'email' => 'indraadikusuma53@gmail.com',
                'password' => bcrypt('Indraadikusuma54321'),
            ],
        ];

        //insert the user into the database
        DB::table('users')->insert($user);

    }

}
