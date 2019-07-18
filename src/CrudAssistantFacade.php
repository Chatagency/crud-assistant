<?php

namespace Chatagency\CrudAssistant;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chatagency\CrudAssistant\Skeleton\SkeletonClass
 */
class CrudAssistantFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'crud-assistant';
    }
}
