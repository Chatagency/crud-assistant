<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\InputCollection;

/**
 * Action Interface.
 */
interface ActionInterface
{
    public function initOutput();

    public static function getIdentifier();

    public function setProcessInternalCollection(bool $processInternalCollection);

    public function prepare(): static;

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input);

    public function cleanup(): static;

    public function controlsRecursion();

    public function controlsExecution();

    public function processInternalCollection();

    public function getOutput();
}
