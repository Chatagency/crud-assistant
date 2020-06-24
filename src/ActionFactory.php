<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionFactoryInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * Actions Factory.
 */
class ActionFactory implements ActionFactoryInterface
{
    /**
     * Actions path.
     *
     * @var array
     */
    protected $path = 'Chatagency\CrudAssistant\Actions\\';
    
    /**
     * Returns action instance.
     *
     * @return ActionInterface
     */
    public function getInstance(string $class)
    {
        $action = $this->isAction($class);

        return new $action();
    }

    /**
     * Returns a specific action class name.
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function isAction(string $class)
    {
        if ($this->isOriginalAction($class)) {
            return $class;
        }

        if (!class_exists($class)) {
            throw new InvalidArgumentException('The '.$class.' Action does not exist or the namespace is wrong', 500);
        }

        if (!$this->extendsActionInterface($class)) {
            throw new InvalidArgumentException('The '.$class.' Action is not extending the interface '.ActionInterface::class, 500);
        }

        return $class;
    }

    /**
     * Verifies if the class is an original
     * action class.
     *
     * @return bool
     */
    public function isOriginalAction(string $class)
    {
        return $this->extendsActionInterface($class)
            && $this->hasActionPath($class)
            && class_exists($class);
    }

    /**
     * Checks if class is in the correct path.
     *
     * @return bool
     */
    protected function hasActionPath(string $class)
    {
        if (false !== strpos($class, $this->path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if class has the correct interface.
     *
     * @return bool
     */
    protected function extendsActionInterface(string $class)
    {
        try {
            $reflector = new ReflectionClass($class);
            $interfaces = $reflector->getInterfaceNames();

            return \in_array(ActionInterface::class, $interfaces);
        } catch (ReflectionException $e) {
            return false;
        }
    }
}
