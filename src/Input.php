<?php

namespace Chatagency\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
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
     * Id
     * @var string
     */
    protected $id;

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
     * Sets Input name
     * @param string $name
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Sets Input label
     * @param string $name
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        
        return $this;
    }
    
    /**
     * Sets Input version
     * @param string $version
     * @return self
     */
    public function setVersion(bool $version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * Sets Input id
     * @param string $id
     * @return self
     */
    public function setId(string $id)
    {
        $this->id = $id;
        
        return $this;
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
     * Returns input id
     * @return int
     */
    public function getId()
    {
        return $this->id ? $this->id : $this->name;
    }
    
    /**
     * Sets Action
     * @param DataContainerInterface $action
     * @param string $key
     * @return self
     */
    public function setAction(DataContainerInterface $action, string $key = null)
    {
        $key = $key ?? $action->key;
        
        $this->actions[$key] = $action;
        
        return $this;
    }
    
    /**
     * Returns action by key
     * @param string $key
     * @return DataContainerInterface
     * @throws
     */
    public function getAction($key)
    {
        if(isset($this->actions[$key])){
            return $this->actions[$key];
        }
        
        throw new InvalidArgumentException("The ".$key." Action has not been registered or does not exist", 500);
    }

}
