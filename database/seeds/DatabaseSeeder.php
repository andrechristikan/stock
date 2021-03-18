<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123123'),
            'role' => 1
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
            'role' => 2
        ]);

        DB::table('items')->insert([
            'id' => 1,
            'name' => 'Item 1',
            'quantity' => 15,
            'amount' => 1000,
            'photo' => null
        ]);


        DB::table('items')->insert([
            'id' => 2,
            'name' => 'Item 2',
            'quantity' => 50,
            'amount' => 500,
            'photo' => null
        ]);


        DB::table('item_flows')->insert([
            'id' => 1,
            'user_id' => 1,
            'item_id' => 1,
            'quantity' => 15,
            'type' => 1,
        ]);

        DB::table('item_flows')->insert([
            'id' => 2,
            'user_id' => 1,
            'item_id' => 2,
            'quantity' => 20,
            'type' => 1,
        ]);

    }
}
