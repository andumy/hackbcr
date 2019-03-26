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
        foreach(User::all() as $user){
            if(!$user->hasRole('admin')){
                $user->department_id = factory(App\Department::class)->create()->id;
                for($i = 0; $i<rand(1, 3);$i++){
                    $user->teams()->save(factory(App\Team::class)->create());
                }
                if( ! ($user->hasRole('dep_worker') || $user->hasRole('dep_lead')) ){
                    $role = Role::where('name','dep_worker')->first();
                    $user->attachRole($role);
                }
                   
                $user->save();
            }
            
        }

    }
}
