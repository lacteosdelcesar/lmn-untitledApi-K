<?php
/**
 * Created by PhpStorm.
 * User: tav0
 * Date: 26/04/16
 * Time: 10:33 AM
 */

namespace App\Resources\Empleados\Models\Lib;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class OModel extends EloquentModel
{
    use SelectLimitTrait;
}