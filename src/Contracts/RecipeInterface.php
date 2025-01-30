<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

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
    public function setModifier(ModifierInterface $modifier);

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
     * Checks if recipe has modifiers.
     *
     * @return bool
     */
    public function hasModifiers();

    /**
     * Sets the ignore value.
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
