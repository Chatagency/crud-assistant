<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel validation rules action class.
 */
class LaravelValidationRules implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $rules = [];

        foreach ($inputs as $input) {
            $name = $input->getName();
            $fieldValidation = $input
                    ->getAction(static::class)
                ?? null;

            if ($fieldValidation) {
                if (is_callable($fieldValidation)) {
                    $rules[$name] = $fieldValidation($input);
                } else {
                    $rules[$name] = $fieldValidation;
                }
            }
        }

        return $rules;
    }
}
