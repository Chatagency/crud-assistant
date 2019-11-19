<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer
 */
class DataContainer implements DataContainerInterface
{
    /**
     * Arbitrary data
     * @var array
     */
    protected $data = [];
    
    /**
     * Constructor for data injection
     * @param $key
     * @param $value
     * @return self
     */
    public function __construct($key = null, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
        
        return $this;
    }
    
    /**
     * Returns the data array
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
    
    /**
     * Magic set method
     * @param string $name
     */
    public function __get(string $name)
    {
        if(!isset($this->data[$name])){
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): ' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_NOTICE
            );
        }
        
        return $this->data[$name];
        
    }
    
    /**
     * Magic set method
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }
    
    /**
     * Magic isset method
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }
    
    /**
     * Magic unset method
     * @param string $name
     */
    public function __unset(string $name)
    {
        unset($this->data[$name]);
    }
    
}
