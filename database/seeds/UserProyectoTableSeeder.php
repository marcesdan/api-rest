<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 20:08
 */

use Illuminate\Database\Seeder;

class UserProyectoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        $proyectos = App\Proyecto::all();
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $proyecto = $proyectos->random();
            $user->proyectos()->detach($proyecto->id);
            $proyecto->users()->attach($user->id);
        }
    }
}
