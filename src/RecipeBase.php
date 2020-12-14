<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Exception;

/**
 * the recipe class stores input
 * information and instructions
 * for the action.
 */
abstract class RecipeBase implements RecipeInterface
{
    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Ignore input.
     *
     * @var bool
     */
    protected $ignored = false;

    /**
     * Input value modifiers.
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * Construct can receive a data array.
     *
     * @return self
     */
    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Returns recipe identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the ignore value.
     *
     * @param mixed $ignore
     *
     * @return self
     */
    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    /**
     * Adds modifier to the array.
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
     * modifiers array.
     *
     * @return self
     */
    public function setModifiers(array $modifiers)
    {
        foreach ($modifiers as $modifier) {
            $this->setModifier($modifier);
        }

        return $this;
    }

    /**
     * Returns modifiers array.
     *
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Checks if input is ignored.
     *
     * @return bool
     */
    public function isIgnored()
    {
        return $this->ignored;
    }

    /**
     * Magic setter method
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        if(!property_exists($this, $name)) {
            throw new Exception('The setter "'.$name.'" is not available on this recipe', 500);
        }
    }

}
