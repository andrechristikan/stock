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
        

        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'user',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'admin',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'id' => 1,
            'role_id' => 1,
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123123'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'role_id' => 2,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('items')->insert([
            'id' => 1,
            'name' => 'Item 1',
            'amount' => 1000,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);


        DB::table('items')->insert([
            'id' => 2,
            'name' => 'Item 2',
            'amount' => 500,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('item_flows')->insert([
            'id' => 1,
            'user_id' => 1,
            'item_id' => 1,
            'quantity' => 15,
            'type' => 'in',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('item_flows')->insert([
            'id' => 2,
            'user_id' => 1,
            'item_id' => 2,
            'quantity' => 20,
            'type' => 'in',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

    }
}
