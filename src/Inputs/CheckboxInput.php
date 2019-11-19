<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Checkbox input Class
 */
class CheckboxInput extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'checkbox';
    
}