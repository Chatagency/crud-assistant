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
        return null;
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
     * Checks if input is ignored
     *
     * @return boolean
     */
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
        if(!empty($this->setters) && !isset($this->setters[$name])) {
            throw new Exception('The setter "'.$name.'" is not available on this recipe', 500);
        }

        return parent::__set($name, $value);
    }

}
