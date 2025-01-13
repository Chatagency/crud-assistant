<?php

declare(strict_types=1);

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
    protected string|null $type = 'select';
}
