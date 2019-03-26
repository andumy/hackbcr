<?php

use Illuminate\Database\Seeder;
use App\Team;
use App\Department;
use App\User;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(User::all() as $user){
            if(!$user->hasRole('admin')){
                $user->department_id = factory(App\Department::class)->create()->id;
                for($i = 0; $i<rand(1, 3);$i++){
                    $user->teams()->save(factory(App\Team::class)->create());
                }
                $user->save();
            }
            
        }

    }
}
