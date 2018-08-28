<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 18:43
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    private $lider;

    /**
     * Los users (users) que pertenecen a éste proyecto.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_proyecto')
            ->using('App\UserProyecto')
            ->withTimestamps();
    }

    /**
     * El lider de éste proyecto.
     */
    public function getLider()
    {
        // lazy initialization
        return isset($this->lider) ?
            $this->lider : new Lider(User::findOrFail($this->lider_id));
    }

    /**
     * El lider de éste proyecto.
     * @param Lider $lider
     */
    public function setLider(Lider $lider)
    {
        $this->lider_id = $lider->getDesarrollador()->id;
    }

    /**
     * @param $user
     * @return bool: true si $user es el lider de este proyecto
     */
    public function esLider($user)
    {
        return $user->id == $this->getLider()->getDesarrollador()->id;
    }
}