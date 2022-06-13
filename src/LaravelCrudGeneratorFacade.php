<?php

namespace Aytacmalkoc\LaravelCrudGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aytacmalkoc\LaravelCrudGenerator\Skeleton\SkeletonClass
 */
class LaravelCrudGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-crud-generator';
    }
}
