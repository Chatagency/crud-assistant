<?php

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Modifier;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Boolean Modifier
 */
class BooleanModifier extends Modifier
{
    
    protected $trueLabel = 'Yes';
    protected $falseLabel = 'No';
    
    /**
     * Modifies value
     *
     * @param  $value
     * @param  DataContainer $data
     *
     * @return mixed
     */
    public function modify($value, DataContainer $data = null)
    {
        $trueLabel = $data->trueLabel ?? $this->trueLabel;
        $falseLabel = $data->falseLabel ?? $this->falseLabel;
        
        return $value ? $trueLabel : $falseLabel;
    }
}
