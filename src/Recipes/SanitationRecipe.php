<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\SanitationAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;

/**
 * Sanitation Action Recipe.
 */
class SanitationRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Sanitation type.
     *
     * @var mixed
     */
    public $type;

    /**
     * Recipe action.
     *
     * @var string
     */
    protected $action = SanitationAction::class;
}
