<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 15/08/18
 * Time: 09:34
 */

namespace App\Services;

use App\User;
use App\Role;

class AuthService
{
    public function register($input)
    {
        // mass assignament
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // por defecto, todos serán usuarios
        $role_user = Role::where('nombre', 'user')->first();
        $user->roles()->attach($role_user);

        // pueden crearse con permisos de administrador
        if ($input['administrador']) {
            $role_admin = Role::where('nombre', 'admin')->first();
            $user->roles()->attach($role_admin);
        }

        return $user;
    }
}