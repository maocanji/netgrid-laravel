<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'admin';
        $role->description = 'admin';
        $role->save();

        $role = new Role();
        $role->name = 'cliente';
        $role->description = 'cliente';
        $role->save();

        $user= User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('carrillo'),
        ]);

        $user->roles()->attach(Role::where('name', 'admin')->first());
    }

}
