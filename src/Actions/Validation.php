<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Crud Class
 */
class Validation implements ActionInterface
{
    /**
     * Action type
     * @var string
     */
    protected $type = 'validation';
    
    /**
     * Executes action
     * @param  array $inputs
     */
    public function execute(array $inputs){
        
        $rules = [];
        
        foreach ($inputs as $input) {
            
            $name = $input->getName();
            $fieldValidation = $input
                    ->getAction($this->type)
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
