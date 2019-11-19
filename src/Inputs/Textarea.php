<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Text Input Class
 */
class Textarea extends Input implements InputInterface
{
    /**
     * Input Type
     */
    protected $type = 'textarea';
    
}
