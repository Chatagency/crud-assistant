<?php

namespace App\Forms\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Hide Password Modifier
 */
class HidePasswordModifier extends Modifier
{
    
    function modify($value, DataContainer $data = null)
    {
        $content = $data && isset($data->content) ? $data->content : '******';
        
        return $content;
    }
}
