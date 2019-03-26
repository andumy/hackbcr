<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;
use App\Permission;

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
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'team_worker',
            'last_name' => 'team_worker',
            'username' => 'team_worker',
            'email' => 'team_worker@app.ro',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'team_lead',
            'last_name' => 'team_lead',
            'username' => 'team_lead',
            'email' => 'team_lead@app.ro',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'dep_worker',
            'last_name' => 'dep_worker',
            'username' => 'dep_worker',
            'email' => 'dep_worker@app.ro',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'first_name' => 'dep_lead',
            'last_name' => 'dep_lead',
            'username' => 'dep_lead',
            'email' => 'dep_lead@app.ro',
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
        

        $manage_user = new Permission();
		$manage_user->name = 'manage-user';
        $manage_user->save();
        $admin_role->attachPermissions(array($manage_user));


        $admin = User::where('email', 'admin@app.ro')->first();
        $admin->attachRole($admin_role);

        $team_worker = User::where('email', 'team_worker@app.ro')->first();
        $team_worker->attachRole($teamworker_role);

        $team_lead = User::where('email', 'team_lead@app.ro')->first();
        $team_lead->attachRole($teamlead_role);

        $dep_worker = User::where('email', 'dep_worker@app.ro')->first();
        $dep_worker->attachRole($depworker_role);

        $dep_lead = User::where('email', 'dep_lead@app.ro')->first();
        $dep_lead->attachRole($deplead_role);

        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
