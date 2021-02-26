<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

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
     * Creates new instance of the class.
     *
     * @param array $args
     *
     * @return RecipeInterface
     */
    public static function make(...$args)
    {
        return new static(...$args);
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
    public function setModifier(Modifier $modifier)
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
     * Checks if input is ignored.
     *
     * @return bool
     */
    public function isIgnored()
    {
        return $this->ignored;
    }
}
