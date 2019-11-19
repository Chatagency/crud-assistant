<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Laravel validation labels class
 */
class LaravelValidationLabels implements ActionInterface
{
    /**
     * Executes action
     * @param  array $inputs
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        
        $labels = [];
        
        foreach ($inputs as $input) {
            
            $name = $input->getName();
            $inputLabels = $input
                    ->getAction(static::class)
                ?? null;
            
            if($inputLabels) {
                $lables = [];
                foreach ($inputLabels as $key => $input) {
                    if(is_callable($inputLabels)){
                        $labels = $inputLabels($labels, $inputLabels, $input);
                    }
                    else {
                        $lables[$key] = $input;
                    }
                }
                
                return $lables;
            }
        }
        
        return $labels;
    }
}
