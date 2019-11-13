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
    
    public function __construct(array $map = null)
    {
        $this->map = $map ?? config('crud-assistant.actions');
    }
    
    /**
     * Adds/replaces action path to the map
     * @param string $key
     * @param ActionInterface $path
     * @return self
     */
    public function addAction(string $key, ActionInterface $path)
    {
        $this->map[$key] = $path;
        
        return $this;
    }
    
    /**
     * Returns action instance
     * @param string $type
     * @return ActionInterface
     */
    public function getInstanse(string $type)
    {
        
    }
    
}
