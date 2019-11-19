<?php

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Crud Class
 */
class Sanitation implements ActionInterface
{
    /**
     * Executes action
     * @param  array $inputs
     * @param DataContainer $params
     */
    public function execute(array $inputs, DataContainer $params = null)
    {
        $rules = $this->rules($inputs);
        $requestArray = $params->requestArray;
        
        foreach ($rules as $input => $rule) {
            if (isset($requestArray[$input])) {
                if (is_array($rule) && isset($rule['rules']) && is_array($rule['rules'])) {
                    $options = isset($rule['options']) && is_array($rule['options']) ? $rule['options'] : [];
                    foreach ($rule['rules'] as $val) {
                        $requestArray = $this->applyFilter($input, $val, $requestArray, $options);
                    }
                    $requestArray[$input.'_raw'] = $requestArray[$input];
                } else {
                    $requestArray = $this->applyFilter($input, $rule, $requestArray);
                }
            }
        }
        
        return $requestArray;
    }
    
    /**
     * Returns rules array
     * @param  array  $inputs
     * @return array
     */
    public function rules(array $inputs){
        
        $rules = [];
        
        foreach ($inputs as $key => $input) {
            
            $sanitation = $input
                    ->getAction(static::class)
                    ->value
                ?? null;
            $name = $input->getName();
            
            if($sanitation) {
                $rules[$name] = $sanitation;
            }
        }
        
        return $rules;
    }
    
    /**
     * Applies Filter
     * @param  string $input
     * @param  string $rule
     * @param  array  $requestArray
     * @param  array  $options
     * @return array
     */
    public function applyFilter(string $input, string $rule, array $requestArray, array $options = [])
    {
        if (is_array($requestArray[$input])) {
            foreach ($requestArray[$input] as $key => $singleInput) {
                $requestArray[$input.'_raw'][$key] = $singleInput;
                $requestArray[$input][$key] = filter_var($singleInput, $rule, $options);
            }
        } else {
            $requestArray[$input.'_raw'] = $requestArray[$input];
            $requestArray[$input] = filter_var($requestArray[$input], $rule, $options);
        }
        
        return $requestArray;
    }
    
}
