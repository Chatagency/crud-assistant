<?php

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Select input class.
 */
class SelectInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'select';
}
