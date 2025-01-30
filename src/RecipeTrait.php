<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ModifierInterface;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * Recipe Trait.
 */
trait RecipeTrait
{
    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Recipe Action. Takes precedent
     * over $identifier
     *
     * @var string
     */
    protected $action;
    
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
     * Returns recipe identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        if($this->action) {
            return  ($this->action)::getIdentifier();
        }

        return $this->identifier;
    }

    /**
     * Sets the ignore value.
     *
     * @param mixed $ignore
     *
     * @return RecipeInterface
     */
    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    /**
     * Adds modifier to the array.
     *
     * @return RecipeInterface
     */
    public function setModifier(ModifierInterface $modifier)
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    /**
     * Adds multiple modifiers to the
     * modifiers array.
     *
     * @return RecipeInterface
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
     * Checks if recipe has modifiers
     *
     * @return boolean
     */
    public function hasModifiers()
    {
        return (bool) count($this->getModifiers());
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
}
