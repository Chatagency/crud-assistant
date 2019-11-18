<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use InvalidArgumentException;

/**
 * Actions Factory
 */
class ActionFactory
{
    /**
     * Actions array actions
     * @var array
     */
    protected $actions = [];
    
    /**
     * Construct for dependency injection
     * @param array $actions
     * @return self
     */
    public function __construct(array $actions = null)
    {
        $this->actions = $actions ?? config('crud-assistant.actions');
        
        return $this;
    }
    
    /**
     * Adds/replaces action path to the actions
     * @param string $type
     * @param string $path
     * @return self
     */
    public function registerAction(string $type, string $path)
    {
        $this->actions[$type] = $path;
        
        return $this;
    }
    
    public function getActions()
    {
        return $this->actions;
    }
    
    /**
     * Returns a specific action class name
     * @param string $type
     * @return string
     */
    public function getAction(string $type)
    {
        $type = strtolower($type);
        
        if(!$this->issetAction($type)){
            throw new InvalidArgumentException("The ".$type." Action has not been registered or does not exist", 500);
        }
        
        return $this->actions[$type];
    }
    
    /**
     * Checks if an action has been registered
     * @param string $type
     * @return bool
     */
    public function issetAction(string $type)
    {
        return isset($this->actions[$type]);
    }
    
    /**
     * Returns action instance
     * @param string $type
     * @return ActionInterface
     * @throws InvalidArgumentException
     */
    public function getInstanse(string $type)
    {
        $action = $this->getAction($type);
        return new $action;
        
    }
    
    
}
