<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 20:08
 */

use Illuminate\Database\Seeder;
use App\Lider;

class ProyectoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        $proyectos = factory(App\Proyecto::class)->times(100)->make();
        foreach ($proyectos as $proyecto){
            $user = $users->random();
            $lider = new Lider($user);
            $proyecto->setLider($lider);
            $proyecto->save();
        }
    }
}