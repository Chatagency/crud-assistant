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
    public function getAction(string $class);

    /**
     * Verifies if the class is an original
     * action class.
     *
     * @return boolean
     */
    public function isOriginalAction(string $class);
}
