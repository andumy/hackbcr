<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'Hr',
        ]);
        
        DB::table('departments')->insert([
            'name' => 'Front-end',
        ]);
        DB::table('departments')->insert([
            'name' => 'Back-end',
        ]);
        DB::table('departments')->insert([
            'name' => 'PR',
        ]);
        DB::table('departments')->insert([
            'name' => 'Logistics',
        ]);

    }
}
