<?php

namespace Chatagency\CrudAssistant\Contracts;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Action Interface
 */
interface ActionInterface
{
    /**
     * Executes action
     * @param  array $inputs
     */
    public function execute(array $inputs);
}
