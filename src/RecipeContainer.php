<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Concerns\isRecipe;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * the recipe class stores input
 * information and instructions
 * for the action.
 */
abstract class RecipeContainer implements RecipeInterface
{
    use isRecipe;
}
