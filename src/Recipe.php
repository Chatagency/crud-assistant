<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Exception;
use InvalidArgumentException;

/**
 * the recipe class stores input
 * information and instructions 
 * for the action
 */
abstract class Recipe extends DataContainer implements RecipeInterface
{
    /**
     * Recipe identifier
     *
     * @var string
     */
    protected $identifier;
    
    /**
     * Ignore input
     *
     * @var boolean
     */
    protected $ignored = false;

    /**
     * Input value modifiers
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * Allowed setters.
     * Ignored if empty.
     *
     * @var array
     */
    protected $setters = [];

    /**
     * Returns recipe identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the ignore value
     * 
     * @return self
     */
    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    /**
     * Adds modifier to the array
     *
     * @param Modifier $modifier
     * 
     * @return self
     */
    public function setModifier(Modifier $modifier)
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    /**
     * Adds multiple modifiers to the 
     * modifiers array
     *
     * @param array $modifiers
     * 
     * @return self
     */
    public function setModifiers(array $modifiers)
    {
        foreach($modifiers as $modifier) {
            $this->setModifier($modifier);
        }

        return $this;
    }

    /**
     * Returns modifiers array
     *
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Checks if input is ignored
     *
     * @return boolean
     */
    public function isIgnored()
    {
        return $this->ignored;
    }

    /**
     * {@inheritdoc}
     */
    public function __set(string $name, $value)
    {
        $this->validateSetter($name);

        return parent::__set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function fill(array $data)
    {
        $this->validateSetters($data);

        return parent::fill($data);
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $data)
    {
        $this->validateSetters($data);
        
        return parent::add($data);
    }

    /**
     * Validates if a key/value
     * array has valid setters
     *
     * @param array $data
     * @return void
     */
    public function validateSetters(array $data)
    {
        foreach($data as $setter => $value) {
            $this->validateSetter($setter);
        }
    }

    /**
     * Checks if a setter is valid
     *
     * @param string $setter
     * @return void
     */
    protected function validateSetter(string $setter)
    {
        /**
         * Check if in setters array
         */
        if(!empty($this->setters) && !in_array($setter, $this->setters)) {
            throw new Exception('The setter "'.$setter.'" is not available on this recipe', 500);
        }
    }

}
