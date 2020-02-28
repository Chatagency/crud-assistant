<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use InvalidArgumentException;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Action base class.
 */
abstract class Action
{
    /**
     * Checks params integrity.
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    protected function checkRequiredParams(DataContainer $data, array $checks)
    {
        if($missing = $data->missing($checks)){
            throw new InvalidArgumentException('The argument '.$missing.' is missing from the DataContainer class', 500);
        }
        
        return true;
    }
    
    /**
     * Applies all modifiers to the a value
     *
     * @param $value
     *
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function modifiers($value, InputInterface $input)
    {
        $recipe = $input->getRecipe(static::class);
        
        if(!is_array($recipe)){
            return false;
        }
        
        $modifiers = $recipe['modifiers'] ?? [];
        
        if(is_array($modifiers) && !$this->empty($value)){
            foreach($modifiers as $modifierName => $data){
                $value = (ModifierFactory::make($modifierName))->modify($value, $data);
            }
        }

        return $value;
    }
    
    /**
     * Checks for value is to be ignored
     *
     * @param $recipe
     *
     * @return bool
     */
    protected function ignore($recipe)
    {
        if(!is_array($recipe)){
            return false;
        }
        
        return $recipe['ignore'] ?? false;
    }
    
    /**
     * Checks if the value is empty
     *
     * @param $value
     *
     * @return bool
     */
    protected function empty($value)
    {
        return $value == '' || is_null($value);
    }
    
    /**
     * Ignore if value is empty
     *
     * @param $value
     *
     * @param $recipe
     *
     * @return bool
     */
    protected function ignoreIfEmpty($value, $recipe)
    {
        if(!is_array($recipe)){
            return false;
        }
        
        if(!$this->empty($value)){
            return false;
        }
        
        return $recipe['ignoreIfEmpty'] ?? false;
    }
    
}
