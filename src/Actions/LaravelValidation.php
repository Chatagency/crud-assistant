<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Crud Class
 */
class LaravelValidation implements ActionInterface
{
    /**
     * Executes action
     * @param  array $inputs
     * @param DataContainer $params
     */
    public function execute(array $inputs, DataContainer $params = null)
    {
        
        $rules = [];
        
        foreach ($inputs as $input) {
            
            $name = $input->getName();
            $fieldValidation = $input
                    ->getAction(static::class)
                    ->value
                ?? null;
            
            if($fieldValidation) {
                if(is_callable($fieldValidation)){
                    $rules[$name] = $fieldValidation($input);
                }
                else {
                    $rules[$name] = $fieldValidation;
                }
            }
        }
        
        return $rules;
    }
}
