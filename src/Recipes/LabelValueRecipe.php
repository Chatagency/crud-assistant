<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;

/**
 * Label Value Action Recipe.
 */
class LabelValueRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Label.
     */
    public $label;

    /**
     * Value.
     */
    public $value;

    /**
     * Recipe action.
     *
     * @var string
     */
    protected $action = LabelValueAction::class;
}
