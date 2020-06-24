<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Action Interface.
 */
interface ActionInterface
{
    /**
     * Execute actions.
     * 
     * @param ActionInterface $action
     *
     * @return DataContainer
     * 
     */
    public function execute(array $inputs, DataContainerInterface $params = null);
}
