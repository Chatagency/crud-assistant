<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Actions\Validation;
use Chatagency\CrudAssistant\Actions\Migrations;
use Chatagency\CrudAssistant\Actions\Sanitation;
use InvalidArgumentException;

/**
 * Actions Factory
 */
class ActionFactory
{
    /**
     * Actions array map
     * @var array
     */
    protected $map = [];
    
    /**
     * Construct for dependency injection
     * @param array $map
     * @return self
     */
    public function __construct(array $map = null)
    {
        $this->map = $map ?? config('crud-assistant.actions');
        
        return $this;
    }
    
    /**
     * Adds/replaces action path to the map
     * @param string $type
     * @param string $path
     * @return self
     */
    public function registerAction(string $type, string $path)
    {
        $this->map[$type] = $path;
        
        return $this;
    }
    
    public function getActions()
    {
        return $this->map;
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
        
        return $this->map[$type];
    }
    
    /**
     * Checks if an action has been registered
     * @param string $type
     * @return bool
     */
    public function issetAction(string $type)
    {
        return isset($this->map[$type]);
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
