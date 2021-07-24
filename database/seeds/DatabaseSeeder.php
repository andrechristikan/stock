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
        // warehouses
        DB::table('warehouses')->insert([
            'id' => 1,
            'name' => 'gudang 1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('warehouses')->insert([
            'id' => 2,
            'name' => 'gudang 2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        // racks
        DB::table('racks')->insert([
            'id' => 1,
            'name' => 'A1',
            'warehouse_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('racks')->insert([
            'id' => 2,
            'name' => 'A2',
            'warehouse_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('racks')->insert([
            'id' => 3,
            'name' => 'A1',
            'warehouse_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('racks')->insert([
            'id' => 4,
            'name' => 'A2',
            'warehouse_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('racks')->insert([
            'id' => 5,
            'name' => 'A3',
            'warehouse_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        // roles
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

        // users
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

        // items
        DB::table('items')->insert([
            'id' => 1,
            'rack_id' => 1,
            'alias_id' => 'BR1',
            'name' => 'Item 1',
            'amount' => 1000,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('items')->insert([
            'id' => 2,
            'rack_id' => 1,
            'alias_id' => 'BR2',
            'name' => 'Item 2',
            'amount' => 500,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('items')->insert([
            'id' => 3,
            'rack_id' => 4,
            'alias_id' => 'BR3',
            'name' => 'Item 3',
            'amount' => 1500,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('items')->insert([
            'id' => 4,
            'rack_id' => 5,
            'alias_id' => 'BR4',
            'name' => 'Item 4',
            'amount' => 2000,
            'photo' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        // item flows
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
        DB::table('item_flows')->insert([
            'id' => 3,
            'user_id' => 1,
            'item_id' => 3,
            'quantity' => 5,
            'type' => 'in',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('item_flows')->insert([
            'id' => 4,
            'user_id' => 1,
            'item_id' => 4,
            'quantity' => 30,
            'type' => 'in',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('item_flows')->insert([
            'id' => 5,
            'user_id' => 1,
            'item_id' => 1,
            'quantity' => -5,
            'type' => 'out',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('item_flows')->insert([
            'id' => 6,
            'user_id' => 1,
            'item_id' => 1,
            'quantity' => -3,
            'type' => 'defect',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

    }
}
