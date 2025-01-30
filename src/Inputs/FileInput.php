<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Inputs;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Input;

/**
 * File input class.
 */
class FileInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected ?string $type = 'file';
}
