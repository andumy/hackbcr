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
            'username' => 'Admin',
            'email' => 'admin@app.ro',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('secret'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin_role = new Role();
		$admin_role->name = 'admin';
		$admin_role->display_name = 'Admin';
		$admin_role->save();

        $manage_user = new Permission();
		$manage_user->name = 'manage-user';
        $manage_user->save();
        
        $admin_role->attachPermissions(array($manage_user));

        $admin = User::where('email', 'admin@app.ro')->first();
        $admin->attachRole($admin_role);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
