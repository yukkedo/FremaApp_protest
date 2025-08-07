<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => '山田 太郎',
                'email' => 'yamadataro@example.com',
                'password' => Hash::make('test12345'),
            ],
            [
                'name' => '田中 次郎',
                'email' => 'tanakajiro@example.com',
                'password' => Hash::make('test12345'),
            ],
            [
                'name' => '鈴木 三郎',
                'email' => 'suzukisaburo@example.com',
                'password' => Hash::make('test12345'),
            ],
        ]);
    }
}
