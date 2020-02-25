<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Is Boolean Modifier
 */
class BooleanModifier extends Modifier
{
    
    protected $trueLabel = 'Yes';
    protected $falseLabel = 'No';
    
    public function modify($value, DataContainer $data = null)
    {
        $trueLabel = $data->trueLabel ?? $this->trueLabel;
        $falseLabel = $data->falseLabel ?? $this->falseLabel;
        
        return $value ? $trueLabel : $falseLabel;
    }
}
