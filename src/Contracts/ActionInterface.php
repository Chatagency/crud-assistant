<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    public function initOutput();
    
    public static function getIdentifier();
    
    public function setProcessInternalCollection(bool $processInternalCollection);

    public function prepare(): static;

    public function execute(InputInterface $input);

    public function cleanup(): static;

    public function controlsRecursion();

    public function controlsExecution();
    
    public function processInternalCollection();

    public function getOutput();
}
