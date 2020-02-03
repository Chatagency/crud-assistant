<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Modifiers;
use Exception;

/**
 * Modifier Factory
 */
class ModifierFactory
{
    const PATH = '\Chatagency\CrudAssistant\Modifiers\\';
    
    public static function make($type)
    {
        if(!class_exists($type)){
            $type = self::PATH.$type;
        }
        
        if(!class_exists($type)){
            throw new Exception("The Modifier ".$type. " could not be found or does not exist" , 500);
        }
        
        $modifier = new $type;
        
        if(!$modifier instanceof Modifiers) {
            throw new Exception("The Modifier ".$type. " is not an instance of ". Modifiers::class , 500);
        }
        
        return $modifier;
        
    }
}
