<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;
use Closure;

/**
 * Label Value Action Recipe.
 */
class LabelValueRecipe extends RecipeBase implements RecipeInterface
{
    public function __construct(
        public string|Closure|null $label = null,
        public $value = null,
    ) 
    {}

    public  static function make(?string $label = null, $value = null,): LabelValueRecipe
    {
        return new static($label, $value);
    }

    /**
     * Recipe action.
     *
     * @var string
     */
    protected $action = LabelValueAction::class;
}
