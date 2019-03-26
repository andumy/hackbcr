<?php

use Illuminate\Database\Seeder;
use App\Team;
use App\Department;
use App\User;
use App\Role;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $depworker_role = Role::where('name','dep_worker')->first();
        $teamworker_role = Role::where('name','team_worker')->first();

        factory(App\User::class, 10)->create()->each(function($u) use($depworker_role,$teamworker_role){
            $u->department_id = Department::inRandomOrder()->first()->id;
            $u->save();
            $u->attachRole($teamworker_role);
            $u->attachRole($depworker_role);
        });

       

    }
}
