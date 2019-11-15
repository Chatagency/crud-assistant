<?php

namespace Chatagency\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Closure;
use InvalidArgumentException;

/**
 * Input Base Class
 */
abstract class Input
{
    /**
     * Name
     * @var string
     */
    protected $name;
    
    /**
     * Label
     * @var string
     */
    protected $label;
    
    /**
     * Version
     * @var bool
     */
    protected $version;
    
    /**
     * Input attributes
     * @var array
     */
    protected $attributes = [];
    
    /**
     * Input Sub Elements
     * @var [type]
     */
    protected $subElements = [];
    
    /**
     * Input Type
     */
    protected $type = null;
    
    /**
     * Input Actions
     * @var array
     */
    protected $actions = [];
    
    /**
     * Class construct
     * @param string $name
     * @param string $label
     * @param int $version
     */
    public function __construct(string $name, string $label = null, int $version = 1)
    {
        $this->name = $name;
        $this->label = $label ? $label : $name;
        $this->version = $version ? $version : 1;
        
        return$this;
    }
    
    /**
     * Sets input label
     * @param string $name
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        
        return $this;
    }
    
    /**
     * Sets input attributes
     * @param string $name
     * @param string|Closure $value
     */
    public function setAttribute(string $name, $value)
    {
        $this->attributes[$name] = $value;
        
        return $this;
    }
    
    /**
     * Sets input sub elements
     * @param array $subElements
     */
    public function setSubElements(array $subElements)
    {
        $this->subElements = $subElements;
        
        return $this;
    }
    
    /**
     * Sets input version
     * @param string $version
     * @return self
     */
    public function setVersion(bool $version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * Sets input type
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }
    
    /**
     * Returns input name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns input label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * Returns input version
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * Returns Input attributes
     * @return string|Closure
     */
    public function getAttribute(string $name)
    {
        if(isset($this->attributes[$name])){
            return $this->attributes[$name];
        }
        
        return null;
    }
    
    /**
     * Returns Input attributes
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    /**
     * Returns input sub elements
     * @return array
     */
    public function getSubElements()
    {
        return $this->subElements;
    }
    
    /**
     * Sets Action
     * @param DataContainerInterface $action
     * @param string $type
     * @return self
     */
    public function setAction(DataContainerInterface $container, string $type = null)
    {
        $type = $type ?? $container->key;
        
        $this->actions[$type] = $container;
        
        return $this;
    }
    
    /**
     * Returns action by type
     * @param string $type
     * @return DataContainerInterface|null
     */
    public function getAction($type)
    {
        if(isset($this->actions[$type])){
            return $this->actions[$type];
        }
        
        return null;
    }

}
