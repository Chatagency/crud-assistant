<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Recipes;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Chatagency\CrudAssistant\RecipeBase;

/**
 * Label Value Action Recipe.
 */
final class LabelValueRecipe extends RecipeBase implements RecipeInterface
{
    /**
     * Recipe action.
     *
     * @var string
     */
    protected $action = LabelValueAction::class;

    public function __construct(
        public \Closure|string|null $label = null,
        public $value = null,
    ) {
    }

    public static function make(?string $label = null, $value = null): self
    {
        return new self($label, $value);
    }
}
