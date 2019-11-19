<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel validation messages class
 */
class LaravelValidationMessages implements ActionInterface
{
    /**
     * Executes action
     * @param  array $inputs
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        
        $messages = [];
        
        foreach ($inputs as $input) {
            
            $name = $input->getName();
            $inputMessages = $input
                    ->getAction(static::class)
                ?? null;
            
            if($inputMessages) {
                if(is_callable($inputMessages)){
                    $messages = $inputMessages($messages, $input);
                }
                else {
                    $messages = $this->createArray($messages, $inputMessages);
                }
            }
        }
        
        return $messages;
    }
    
    public function createArray($messages, $inputMessages)
    {
        foreach ($inputMessages as $keyMessage => $message) {
            $messages[$keyMessage] = $message;
        }
        return $messages;
    }
    
}
