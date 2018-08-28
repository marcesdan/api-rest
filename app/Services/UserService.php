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

class UserService
{
    public function getAll() {
        return User::all();
    }

    public function get($id) {
        return User::find($id);
    }

    public function save($input, $user = null) {
        return isset($user)
            ? $user->fill($input)
            : User::create($input);
    }

    public function destroy($id) {
        return User::destroy($id);
    }

    public function cambiarRol($user) {
        $role_admin = Role::where('nombre', 'admin')->first();
        $user->hasRole('admin')
            ? $user->roles()->detach($role_admin)
            : $user->roles()->attach($role_admin);
    }
}