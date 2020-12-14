<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeContainer;

/**
 * Sanitation Action Recipe.
 */
class SanitationActionRecipe extends RecipeContainer implements RecipeInterface
{
    /**
     * Allowed setters.
     * Ignored if empty.
     *
     * @var array
     */
    protected $setters = ['type'];

    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier = SanitationAction::class;
}
