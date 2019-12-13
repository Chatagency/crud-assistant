<?php

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
            $inputMessages = $input->getRecipe(static::class) ?? null;

            if ($inputMessages) {
                if (is_callable($inputMessages)) {
                    $messages = $inputMessages($messages, $input);
                } else {
                    foreach ($inputMessages as $keyMessage => $message) {
                        $messages[$keyMessage] = $message;
                    }
                }
            }
        }

        return $messages;
    }
}
