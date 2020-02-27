<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Modifier;
use Exception;

/**
 * Modifier Factory
 */
class ModifierFactory
{
    const PATH = '\Chatagency\CrudAssistant\Modifiers\\';
    
    public static function make($type)
    {
        $typeOrig = $type;
        
        if(!class_exists($type)){
            $type = self::PATH.$type;
        }
        
        if(!class_exists($type)){
            throw new Exception("The Modifier ".$typeOrig. " could not be found or does not exist" , 500);
        }
        
        $modifier = new $type;
        
        if(!$modifier instanceof Modifier) {
            throw new Exception("The Modifier ".$typeOrig. " is not an instance of ". Modifier::class , 500);
        }
        
        return $modifier;
        
    }
}
