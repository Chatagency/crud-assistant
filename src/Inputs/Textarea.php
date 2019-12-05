<?php

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Textarea input class.
 */
class Textarea extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'textarea';
}
