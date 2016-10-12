<?php
/**
 * Created by PhpStorm.
 * User: tav0
 * Date: 26/04/16
 * Time: 10:26 AM
 */

namespace App\Resources\Empleados\Models\Lib;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SelectLimitScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        $queryable = $builder->getModel()->getQueryable();

        $query->columns = $queryable;

        $orderBy = $builder->getModel()->getOrder();
        if ($orderBy) return $query->orderBy($orderBy[0], $orderBy[1]);
    }
}