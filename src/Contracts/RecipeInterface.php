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
     * Returns recipe identifier
     *
     * @return void
     */
    public function getIdentifier();

    /**
     * Adds modifier to the array
     *
     * @param Modifier $modifier
     * 
     * @return self
     */
    public function setModifier(Modifier $modifier);

    /**
     * Adds multiple modifiers to the 
     * modifiers array
     *
     * @param array $modifiers
     * 
     * @return self
     */
    public function setModifiers(array $modifiers);

    /**
     * Checks if input is ignored
     *
     * @return boolean
     */
    public function isIgnored();

}
