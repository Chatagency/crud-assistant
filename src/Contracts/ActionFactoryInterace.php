<?php

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
     * @param string $type
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
     * @param string $type
     *
     * @return bool
     */
    public function issetAction(string $type);

    /**
     * Returns action instance.
     *
     * @param string $type
     *
     * @return ActionInterface
     */
    public function getInstanse(string $type);

    /**
     * Returns a specific action class name.
     *
     * @param string $type
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getAction(string $type);
}
