<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Text Input Class
 */
class GenericInput extends Input implements InputInterface
{
    protected $type = null;
    
    /**
     * Sets type
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
        
        return $this;
    }
    
}
