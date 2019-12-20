<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Checkbox input Class.
 */
class CheckboxInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'checkbox';
}
