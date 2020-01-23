<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Radio button input class.
 */
class RadioInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'radio';
}
