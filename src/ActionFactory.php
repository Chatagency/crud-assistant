<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionFactoryInterace;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use InvalidArgumentException;

/**
 * Actions Factory.
 */
class ActionFactory implements ActionFactoryInterace
{
    /**
     * Actions array actions.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Construct for dependency injection.
     *
     * @return self
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Adds/replaces action path to the actions.
     *
     * @param string $type
     *
     * @return self
     */
    public function registerAction(string $type)
    {
        $this->actions[] = $type;

        return $this;
    }

    /**
     * Returns actions array.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Checks if an action has been registered.
     *
     * @param string $type
     *
     * @return bool
     */
    public function issetAction(string $type)
    {
        return false !== array_search($type, $this->actions);
    }

    /**
     * Returns action instance.
     *
     * @param string $type
     *
     * @return ActionInterface
     */
    public function getInstanse(string $type)
    {
        $action = $this->getAction($type);

        return new $action();
    }

    /**
     * Returns a specific action class name.
     *
     * @param string $type
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getAction(string $type)
    {
        $key = array_search($type, $this->actions);

        if (false === $key) {
            throw new InvalidArgumentException('The '.$type.' Action has not been registered or does not exist', 500);
        }

        return $this->actions[$key];
    }
}
