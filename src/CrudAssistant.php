<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use BadMethodCallException;

/**
 * Crud Assistant Manager
 */
class CrudAssistant
{
    /**
     * Action factory
     * @var ActionFactory
     */
    protected $actionFactory;
    
    /**
     * Input collection
     * @var InputCollection
     */
    protected $collection;
    
    /**
     * Construct
     * @param array $inputs
     * @return self
     */
    public function __construct(array $inputs = [])
    {
        $this->actionFactory = new ActionFactory($this->getActionsConfig());
        $this->collection = new InputCollection($inputs, $this->actionFactory);
        
        return $this;
    }
    
    /**
     * Creates new instance of this class
     * @param  array  $inputs [description]
     * @return self
     */
    public static function make(array $inputs = [])
    {
        return new static($inputs);
    }
    
    /**
     * Returns input collection
     * @return InputCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }
    
    /**
     * Magic call method to tide class to collection and actions
     * @param $name
     * @param $arguments [description]
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        /**
         * Check if is action
         */
        $action = $this->getActionBase($name);
        if($action) {
            
            if(!$arguments instanceof DataContainer){
                $arguments = new DataContainer($arguments[0]);
            }
            
            return $this->collection->execute($action, $arguments);
        }
        
        /**
         * Check if is a collection method
         */
        if(method_exists($this->collection, $name)) {
            
            $object_array = [$this->collection, $name];
            return call_user_func_array($object_array, $arguments);
        }
        
        throw new BadMethodCallException('Method ' . $name . ' not exists in '. __CLASS__);
        
    }
    
    /**
     * Returns action class name without path
     * @param string $action
     * @return string|null
     */
    protected function getActionBase(string $action)
    {
        $actions = $this->actionFactory->getActions();
        
        foreach ($actions as $key => $value) {
            $base = substr(strrchr($value, "\\"), 1);
            if($base == ucfirst($action)){
                return $value;
            }
        }
        
        return null;
    }
    
    /**
     * Returns config array
     * @return array
     */
    protected function getActionsConfig()
    {
        return config('crud-assistant.actions');
    }
    
}
