<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * File cnput class
 */
class FileInput extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'file';
    
}