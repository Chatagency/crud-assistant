<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Text input class
 */
class TextInput extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'text';
    
}
