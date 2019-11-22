<?php

namespace Chatagency\CrudAssistant\Inputs;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Select input class
 */
class SelectInput extends Input implements InputInterface
{
    /**
     * Input type
     */
    protected $type = 'select';
}