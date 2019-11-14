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
     * @param ActionInterface $path
     * @return self
     */
    public function registerAction(string $type, ActionInterface $path)
    {
        $this->map[$type] = $path;
        
        return $this;
    }
    
    /**
     * Returns action instance
     * @param string $type
     * @return ActionInterface
     * @throws InvalidArgumentException
     */
    public function getInstanse(string $type)
    {
        $type = strtolower($type);
        
        if(!isset($this->map[$type])){
            throw new InvalidArgumentException("The ".$type." Action has not been registered or does not exist", 500);
        }
        
        $action = $this->map[$type];
        return new $action;
        
    }
    
}
