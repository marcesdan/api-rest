<?php
/**
 * Created by PhpStorm.
 * UserRequest: marces
 * Date: 31/07/18
 * Time: 18:40
 */

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProyecto  extends Pivot
{
    protected $table = 'user_proyecto';
}