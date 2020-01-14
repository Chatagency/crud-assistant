<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use InvalidArgumentException;

/**
 * Actions Factory Interface.
 */
interface ActionFactoryInterace
{
    /**
     * Construct for dependency injection.
     *
     * @return self
     */
    public function __construct(array $actions);

    /**
     * Adds/replaces action path to the actions.
     *
     * @return self
     */
    public function registerAction(string $type);

    /**
     * Returns actions array.
     *
     * @return array
     */
    public function getActions();

    /**
     * Checks if an action has been registered.
     *
     * @return bool
     */
    public function issetAction(string $type);

    /**
     * Returns action instance.
     *
     * @return ActionInterface
     */
    public function getInstanse(string $type);

    /**
     * Returns a specific action class name.
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function getAction(string $type);
}
