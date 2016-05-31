<?php
/**
 * Created by tav0
 * Date: 30/05/16
 * Time: 01:04 PM
 */

namespace App\Resources\Empleados\Models\Relations;


use Illuminate\Database\Eloquent\Relations\HasOne;

class HasOneContrato extends HasOne
{

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        if (static::$constraints) {
            $this->query->where($this->foreignKey, '=', str_pad($this->getParentKey(), 15));

            $this->query->whereNotNull($this->foreignKey);
        }
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array $models
     * @return void
     */
    public function addEagerConstraints(array $models)
    {
        $keys = [];
        foreach ($this->getKeys($models, $this->localKey) as $key) {
            $keys[] = str_pad($key, 15);
        }
        $this->query->whereIn($this->foreignKey, $keys);
    }
}