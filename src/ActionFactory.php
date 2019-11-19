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
    public function __construct(array $actions)
    {
        $this->actions = $actions;
        
        return $this;
    }
    
    /**
     * Adds/replaces action path to the actions
     * @param string $type
     * @param string $path
     * @return self
     */
    public function registerAction(string $type)
    {
        $this->actions[] = $type;
        
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
        $key = array_search($type, $this->actions);
        
        if($key === false){
            throw new InvalidArgumentException("The ".$type." Action has not been registered or does not exist", 500);
        }
        
        return $this->actions[$key];
    }
    
    /**
     * Checks if an action has been registered
     * @param string $type
     * @return bool
     */
    public function issetAction(string $type)
    {
        return array_search($type, $this->actions) !== false ;
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
