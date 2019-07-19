<?php

namespace Chatagency\CrudAssistant;
use Chatagency\CrudAssistant\Validation;
use Chatagency\CrudAssistant\Sanitation;

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
     * Class construct
     * @param [type] $name
     * @param [type] $version
     */
    public function __construct(string $name = null, bool $version = null)
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
     * Sets validation object
     * @param Validation $validation
     * @return self
     */
    public function setValidation(Validation $validation)
    {
        $this->validation = $validation;
        
        return $this;
    }
    
    /**
     * Sets sanitation object
     * @param Sanitation $sanitation
     * @return self
     */
    public function setSanitation(Sanitation $sanitation)
    {
        $this->sanitation = $sanitation;
        
        return $this;
    }
    
}
