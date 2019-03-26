<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;
use App\Permission;
use App\Department;

use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $toTruncate = ['users', 'password_resets', 'roles', 'role_user', 'permissions', 'permission_role'];

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
		
		foreach($this->toTruncate as $table) {
			DB::table($table)->truncate();
        }
        
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Cristi',
            'last_name' => 'Popescu',
            'email' => 'cristi@app.ro',
            'department_id' => Department::inRandomOrder()->first()->id,
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Radu',
            'last_name' => 'Stefan',
            'department_id' => Department::inRandomOrder()->first()->id,
            'email' => 'radu@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Mihai',
            'last_name' => 'Cernea',
            'department_id' => Department::inRandomOrder()->first()->id,
            'email' => 'mihai@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Costin-Mihai',
            'last_name' => 'Gabrielovici',
            'department_id' => Department::inRandomOrder()->first()->id,
            'email' => 'costi@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Stefania',
            'last_name' => 'Oancea',
            'department_id' => Department::inRandomOrder()->first()->id,
            'email' => 'stefania@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Mirel',
            'last_name' => 'Scobornovici',
            'department_id' => Department::inRandomOrder()->first()->id,
            'email' => 'mirel@app.ro',
            'phone' => '40722797747',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin_role = new Role();
		$admin_role->name = 'admin';
		$admin_role->display_name = 'Admin';
        $admin_role->save();
        
        $teamworker_role = new Role();
		$teamworker_role->name = 'team_worker';
		$teamworker_role->display_name = 'team_worker';
		$teamworker_role->save();
        
        $teamlead_role = new Role();
		$teamlead_role->name = 'team_lead';
		$teamlead_role->display_name = 'team_lead';
        $teamlead_role->save();

        $depworker_role = new Role();
		$depworker_role->name = 'dep_worker';
		$depworker_role->display_name = 'dep_worker';
		$depworker_role->save();
        
        $deplead_role = new Role();
		$deplead_role->name = 'dep_lead';
		$deplead_role->display_name = 'dep_lead';
        $deplead_role->save();
        

        $admin = User::where('email', 'admin@app.ro')->first();
        $admin->attachRole($admin_role);

        $user = User::where('email', 'cristi@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        $user = User::where('email', 'radu@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        $user = User::where('email', 'mihai@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        $user = User::where('email', 'costi@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        $user = User::where('email', 'stefania@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        $user = User::where('email', 'mirel@app.ro')->first();
        $user->attachRole($teamworker_role);
        $user->attachRole($depworker_role);

        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
