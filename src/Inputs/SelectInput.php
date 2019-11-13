<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Text Input Class
 */
class SelectInput extends Input implements InputInterface
{
    protected $type = 'select';
    
    protected $options = [];
    
    /**
     * Sets select options
     * @param array $options
     * @return self
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        
        return $this;
    }
    
}