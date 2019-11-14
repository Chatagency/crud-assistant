<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer
 */
class DataContainer implements DataContainerInterface
{
    /**
     * Key
     * @var string
     */
    public $key;
    
    /**
     * Value
     * @var mixed
     */
    public $value;
    
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
     * Sets Key
     * @param string $key
     * @return self
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        
        return $this;
    }
    
    /**
     * Sets value
     * @param mixed $value
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;
        
        return $this;
    }
    
    public function __get($name)
    {
        if(isset($this->data[$name])){
            return $this->data[$name];
        }
        
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        
        return null;
    }
    
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function __isset($name)
    {
        return isset($this->data[$value]);
    }
    
    public function __unset($name)
    {
        unset($this->data[$name]);
    }
    
    public function __toString()
    {
        $data = $this->data;
        $data['key'] = $this->key;
        $data['value'] = $this->value;
        
        return json_encode($data, JSON_FORCE_OBJECT);
    }
    
}
