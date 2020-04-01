<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionFactoryInterace;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use ReflectionClass;
use InvalidArgumentException;
use ReflectionException;

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
     * Actions path.
     *
     * @var array
     */
    protected $path = 'Chatagency\CrudAssistant\Actions\\';

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
     * @return self
     */
    public function registerAction(string $class)
    {
        $this->actions[] = $class;

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
     * @return bool
     */
    public function issetAction(string $class)
    {
        if($this->isPackageAction($class)) {
            return true;
        }
        
        return false !== array_search($class, $this->actions);
    }

    /**
     * Returns action instance.
     *
     * @return ActionInterface
     */
    public function getInstanse(string $class)
    {
        $action = $this->getAction($class);

        return new $action();
    }

    /**
     * Returns a specific action class name.
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function getAction(string $class)
    {
        if($this->isPackageAction($class)) {
            return $class;
        }

        if (!array_search($class, $this->actions)) {
            throw new InvalidArgumentException('The '.$class.' Action has not been registered or does not exist', 500);
        }

        if (!class_exists($class)) {
            throw new InvalidArgumentException('The '.$class.' Action has not been registered or the namespace is wrong', 500);
        }

        if (!$this->isCorrectPath($class)) {
            throw new InvalidArgumentException('The '.$class.' Action is not extending the interface '.ActionInterface::class, 500);
        }

        return $class;
    }

    /**
     * Adds namespace to a classname
     *
     * @param string $class
     * @return string
     */
    public function addNamespace(string $class)
    {
        return $this->path.ucfirst($class);
    }

    public function isPackageAction(string $class)
    {
        return $this->isCorrenctInterface($class) && $this->isCorrectPath($class);
    }

    /**
     * Checks if class is in the correct path
     *
     * @param string $class
     * 
     * @return boolean
     */
    protected function isCorrectPath(string $class)
    {
        if (strpos($class, $this->path) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Checks if class has the correct interface
     *
     * @param string $class
     * @return boolean
     */
    protected function isCorrenctInterface(string $class)
    { 
        try {
            $reflector = new ReflectionClass($class);
            $interfaces = $reflector->getInterfaceNames();
            return in_array(ActionInterface::class, $interfaces);
        }
        catch(ReflectionException $e) {
            return false;
        }
    }

}
