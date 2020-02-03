<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Is File Modifier
 */
class IsRouteUrl extends Modifier
{
    
    public function modify($value, DataContainer $data = null)
    {
        $route = $data->route;
        return route($route, [$value]);
    }
}
