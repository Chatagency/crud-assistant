<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Option input class.
 */
class OptionInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'option';
}
