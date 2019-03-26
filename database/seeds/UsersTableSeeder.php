<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@app.ro',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
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
    }
}
