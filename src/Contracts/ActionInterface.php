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
     * @param DataContainer $params
     */
    public function execute(array $inputs, DataContainer $params = null);
}
