<?php

use Illuminate\Database\Seeder;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            'name' => 'Project 15',
        ]);
        DB::table('teams')->insert([
            'name' => 'Online Banking',
        ]);
        DB::table('teams')->insert([
            'name' => 'Bug fixing',
        ]);
        DB::table('teams')->insert([
            'name' => 'New Business',
        ]);
        DB::table('teams')->insert([
            'name' => 'Some other team',
        ]);

    }
}
