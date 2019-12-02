<?php

namespace Chatagency\CrudAssistant;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\InputCollection;

/**
 * Crud Assistant Manager
 */
class CrudAssistant
{
    protected $collections = [];
    
    public static function make()
    {
        return new static();
    }
    
    public function createColletion($name, array $inputs = [])
    {
        $this->collections[$name] = new InputCollection($inputs, new ActionFactory($this->getActionsConfig()));
        
        return $this;
    }
    
    public function __get(string $name)
    {
        if(!isset($this->collections[$name])){
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE
            );
        }
        
        return $this->collections[$name];
        
    }
    
    protected function getActionsConfig()
    {
        return config('crud-assistant.actions');
    }

    
}
