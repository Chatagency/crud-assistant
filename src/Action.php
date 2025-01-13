<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Concerns\isAction;

/**
 * Action base class.
 */
abstract class Action
{
    use isAction;
}
