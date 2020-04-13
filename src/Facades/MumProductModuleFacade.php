<?php

namespace Thelabdevtz\MumProductModule\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thelabdevtz\MumProductModule\Skeleton\SkeletonClass
 */
class MumProductModuleFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mum-product-module';
    }
}
