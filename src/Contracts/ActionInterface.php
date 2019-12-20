<?php

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    /**
     * Executes action.
     *
     * @param array $inputs
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null);
}
