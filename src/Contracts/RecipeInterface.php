<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\Modifier;

/**
 * Recipe Interface.
 */
interface RecipeInterface
{
    /**
     * Returns recipe identifier.
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Adds modifier to the array.
     *
     * @return self
     */
    public function setModifier(Modifier $modifier);

    /**
     * Adds multiple modifiers to the
     * modifiers array.
     *
     * @return self
     */
    public function setModifiers(array $modifiers);

    /**
     * Returns modifiers array.
     *
     * @return array
     */
    public function getModifiers();

    /**
     * Checks if recipe has modifiers
     *
     * @return boolean
     */
    public function hasModifiers();

    /**
     * Sets the ignore value.
     *
     * @param mixed $ignore
     *
     * @return self
     */
    public function ignore($ignore = true);

    /**
     * Checks if input is ignored.
     *
     * @return bool
     */
    public function isIgnored();
}
