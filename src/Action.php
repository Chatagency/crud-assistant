<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Concerns\IsAction;

/**
 * Action base class.
 */
abstract class Action
{
    use IsAction;

    protected $controlsRecursion = false;

    protected $controlsExecution = false;

    protected $processInternalCollection = false;
}
