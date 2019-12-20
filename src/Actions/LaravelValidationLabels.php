<?php

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
     * @param array $inputs
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $labels = [];

        foreach ($inputs as $input) {
            $name = $input->getName();
            $label = $input->getLabel();
            $inputLabels = $input->getRecipe(static::class) ?? null;

            if ($inputLabels) {
                if (is_callable($inputLabels)) {
                    $labels = $inputLabels($labels, $input);
                } else {
                    $labels[$name] = $inputLabels;
                }
            } else {
                $labels[$name] = $label;
            }
        }

        return $labels;
    }
}
