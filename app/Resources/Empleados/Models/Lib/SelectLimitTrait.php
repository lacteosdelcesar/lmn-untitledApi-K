<?php
/**
 * Created by PhpStorm.
 * User: tav0
 * Date: 26/04/16
 * Time: 10:22 AM
 */

namespace App\Resources\Empleados\Models\Lib;


trait SelectLimitTrait
{
    protected $queryable = ['*'];

    protected $orderBy = false;

    public static function bootSelectLimitTrait()
    {
        static::addGlobalScope(new SelectLimitScope());
    }

    public function getQueryable()
    {
        if(!$this->queryable) return array('*');

        return $this->queryable;
    }

    public function getOrder()
    {
        if($this->orderBy) {
            if (!is_array($this->orderBy)) throw new \Exception('orderBy debe ser array en ' . static::class);

            if (!isset($this->orderBy[1])) {
                $this->orderBy[1] = 'asc';
            }
        }
        return $this->orderBy;
    }
}