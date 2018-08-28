<?php

use Illuminate\Database\Seeder;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('nombre', 'user')->first();
        $role_admin = Role::where('nombre', 'admin')->first();

    	$users = factory(App\User::class)->times(100)->make();
        foreach ($users as $user){
            //$user->createToken('MyApp')->accessToken;
            $user->save();
            $user->roles()->attach($role_user);
        }

        // me creo como administrador :)
        $user = App\User::create([
            'nombre' => 'Mariano César',
            'apellido' => "D'Angelo",
            'email' => 'marianod93@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm' //secret
        ]);
        //$user->createToken('MyApp')->accessToken;
        $user->roles()->attach($role_admin);
        $user->roles()->attach($role_user);
    }
}
