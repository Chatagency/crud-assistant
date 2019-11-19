<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Radio button input Class
 */
class RadioInput extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'radio';
    
}