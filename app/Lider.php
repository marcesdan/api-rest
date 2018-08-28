<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 18:41
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Lider extends Model
{
    private $user;

    /**
     * Lider constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getDesarrollador()
    {
        return $this->user;
    }

    public function setDesarrollador(User $user)
    {
        $this->user = $user;
    }

}