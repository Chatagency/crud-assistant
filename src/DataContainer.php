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
    
}
