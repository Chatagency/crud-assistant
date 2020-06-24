<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use InvalidArgumentException;

/**
 * Actions Factory Interface.
 */
interface ActionFactoryInterface
{
    /**
     * Returns action instance.
     *
     * @return ActionInterface
     */
    public function getInstance(string $class);

    /**
     * Returns a specific action class name.
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function isAction(string $class);

}
