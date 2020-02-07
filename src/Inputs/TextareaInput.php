<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * Textarea input class.
 */
class TextareaInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected $type = 'textarea';
}
