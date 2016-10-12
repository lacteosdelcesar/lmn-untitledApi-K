<?php
/**
 * Created by tav0
 * Date: 9/04/16
 * Time: 08:39 PM
 */

namespace App\Resources\Auth\Models;


use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nombre'];
}