<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * File Input Class
 */
class FileInput extends Input implements InputInterface
{
    /**
     * Input Type
     */
    protected $type = 'file';
    
}