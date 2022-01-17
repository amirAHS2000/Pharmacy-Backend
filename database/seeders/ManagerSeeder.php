<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
           'first_name' => 'Mr.',
           'last_name' => 'Boss',
           'phone' => '0111',
           'gender' => 'male',
           'birthday' => '2001-01-01',
           'degree' => 'phd',
           'job' => 'manager',
           'address' => 'one st. , no.1',
           'nat_num' => '111',
           'role' => 'manager',
        ]);
        DB::table('users')->insert([
            'ref_id' => '1',
            'phone' => '0111',
            'type' => 'manager',
            'password' => Hash::make('12345678')
        ]);
    }
}
