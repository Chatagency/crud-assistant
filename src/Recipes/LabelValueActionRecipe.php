<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;

/**
 * Label Value Action Recipe.
 */
class LabelValueActionRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Label
     */
    public $label;

    /**
     * Value
     */
    public $value;

    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier = LabelValueAction::class;
}
