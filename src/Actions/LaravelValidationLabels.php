<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel validation labels action class.
 */
class LaravelValidationLabels extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $labels = [];

        foreach ($inputs as $input) {
            $name = $input->getName();
            $label = $input->getLabel();
            $recipe = $input->getRecipe(static::class);

            if ($this->ignore($recipe)) {
                continue;
            }

            if ($recipe) {
                if (\is_callable($recipe)) {
                    $labels = $recipe($labels, $input);
                } else {
                    $labels[$name] = $recipe;
                }
            } else {
                $labels[$name] = $label;
            }
        }

        return $labels;
    }
}
