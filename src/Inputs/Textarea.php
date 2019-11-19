<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Textarea input class
 */
class Textarea extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'textarea';
    
}
