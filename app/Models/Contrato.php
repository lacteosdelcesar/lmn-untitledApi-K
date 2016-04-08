<?php
/**
 * Created by tav0
 * Date: 6/04/16
 * Time: 11:53 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $connection = 'oracle';
    protected $table = 'contratos';
    protected $primaryKey = 'codigo';
    public $timestamps = false;

    protected $visible = [
        'codigo',
        'salario'
    ];
}