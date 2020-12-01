<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Exception;

/**
 * Recipe.
 */
abstract class Recipe extends DataContainer
{
    protected $ignored = false;

    protected $modifiers = [];

    protected $setters = [];

    public function __construct(array $data = [])
    {
        
        
        return parent::__construct($data);
    }
    
    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    public function setModifier(Modifier $modifier)
    {
        $this->modifiers[] = $modifier;
    }

    public function setModifiers(array $modifiers)
    {
        $this->modifiers = array_merge($this->modifiers, $modifiers);
    }

    public function isIgnored()
    {
        return $this->ignored;
    }

    /**
     * Magic set method.
     */
    public function __set(string $name, $value)
    {
        /**
         * Check if in setters array
         */
        if(!empty($this->setters)) {
            if(!isset($this->setters[$name])) {
                throw new Exception('The setter "'.$name.'" is not available on this recipe', 500);
            }
            
        }

        return parent::__set($name, $value);
    }

    public function validateSetter(string $name)
    {
        
    }

}
