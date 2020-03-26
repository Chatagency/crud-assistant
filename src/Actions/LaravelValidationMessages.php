<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel validation messages action class.
 */
class LaravelValidationMessages extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $messages = [];

        foreach ($inputs as $input) {
            $name = $input->getName();
            $recipe = $input->getRecipe(static::class);

            if ($this->ignore($recipe)) {
                continue;
            }

            if ($recipe) {
                if (\is_callable($recipe)) {
                    $messages = $recipe($messages, $input);
                } else {
                    foreach ($recipe as $keyMessage => $message) {
                        $messages[$keyMessage] = $message;
                    }
                }
            }
        }

        return $messages;
    }
}
