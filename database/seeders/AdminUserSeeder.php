<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'            => str::uuid(),
            'name'          => 'Admin',
            'email'         => 'admin@gmail.com',
            'password'      => Hash::make('admin'),
            'roles'         => 'Super Admin',
            'is_active'     => 1,
            'created_at'    => "2023-11-22 16:30:18",
            'updated_at'    => "2023-11-22 16:30:18",
        ]);
    }
}
