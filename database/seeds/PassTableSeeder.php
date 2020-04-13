<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('passwords')->insert([
            'name' => 'MasterKey',
            'password' => 'Master.2020',
            'status' => 1
        ]);
    }
}
