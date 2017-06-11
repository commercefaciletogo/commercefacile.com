<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('roles')->insert($this->get_data());
    }

    private function get_data()
    {
        return [
            ['name' => 'admin'],
            ['name' => 'employee'],
            ['name' => 'manager'],
            ['name' => 'agent']
        ];
    }
}
