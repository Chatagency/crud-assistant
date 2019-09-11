<?php

namespace Chatagency\CrudAssistant;
use Chatagency\CrudAssistant\Contracts\ProcessInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
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
     * Input Processes
     * @var array
     */
    protected $processes = [];
    
    /**
     * Input Actions
     * @var array
     */
    protected $actions = [];
    
    
    /**
     * Class construct
     * @param [type] $name
     * @param [type] $version
     */
    public function __construct(string $name = null, string $label = null, bool $version = null)
    {
        if($name){
            $this->name = $name;
        }
        
        if($version){
            $this->version = $version;
        }
        
        return$this;
    }
    
    /**
     * Sets Input Name
     * @param string $name
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Sets Input Name
     * @param string $name
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        
        return $this;
    }
    
    /**
     * Sets Input Version
     * @param string $version
     * @return self
     */
    public function setVersion(bool $version)
    {
        $this->version = $version;
        
        return $this;
    }
    
    /**
     * Sets Input Id
     * @param string $id
     * @return self
     */
    public function setId(string $id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Sets Process
     * @param ProcessInterface $process
     * @param string $key
     * @return self
     */
    public function setProcess(ProcessInterface $process, string $key = null)
    {
        $key = $key ?? get_class($process);
        
        $this->processes[$key] = $process;
        
        return $this;
    }
    
    /**
     * Returns process by ky
     * @param  string $key
     * @return ProcessInterface
     * @throws
     */
    public function getProcess($key)
    {
        if(isset($this->processes[$key])){
            return $this->processes[$key];
        }
        
        throw new InvalidArgumentException("The ".$key." Process has not been registered or does not exist", 500);
    }
    
    
    /**
     * Sets Action
     * @param ProcessInterface $process
     * @param string $key
     * @return self
     */
    public function setAction(ProcessInterface $action, string $key = null)
    {
        $key = $key ?? get_class($action);
        
        $this->actions[$key] = $action;
        
        return $this;
    }
    
    
}
