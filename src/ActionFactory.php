<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionFactoryInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Actions Factory.
 */
class ActionFactory implements ActionFactoryInterface
{
    /**
     * Returns action instance.
     *
     * @return ActionInterface
     * 
     * @throws InvalidArgumentException
     */
    public function getInstance(string $action)
    {
        if(!$this->isAction($action)) {
            throw new InvalidArgumentException('The action '.$action.' is not valid', 500);
        }
        
        return new $action();
    }

    /**
     * Returns a specific action class name.
     *
     * @return string
     */
    public function isAction(string $class)
    {
        if (!class_exists($class)) {
            return false;
        }

        if (!$this->extendsActionInterface($class)) {
            return false;
        }

        return $class;
    }

    /**
     * Checks if class has the correct interface.
     *
     * @return bool
     */
    protected function extendsActionInterface(string $class)
    {
        $reflector = new ReflectionClass($class);
        $interfaces = $reflector->getInterfaceNames();

        return \in_array(ActionInterface::class, $interfaces);
    }
}
