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
     * Action type
     * @var string
     */
    protected $type = 'sanitation';
    
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
                    $requestArray[$input.'_raw'] = $requestArray[$input];
                    foreach ($rule['rules'] as $val) {
                        $requestArray[$input] = filter_var($requestArray[$input], $val, $options);
                    }
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
                    ->getAction($this->type)
                    ->value
                ?? null;
            $name = $input->getName();
            
            if($sanitation) {
                $rules[$name] = $sanitation;
            }
        }
        
        return $rules;
    }
    
    public function applyFilter($input, $rule, $requestArray, $options = [])
    {
        if (is_array($requestArray[$input])) {
            foreach ($requestArray[$input] as $key => $single_input) {
                $requestArray[$input.'_raw'][$key] = $single_input;
                $requestArray[$input][$key] = filter_var($single_input, $rule, $options);
            }
        } else {
            $requestArray[$input.'_raw'] = $requestArray[$input];
            $requestArray[$input] = filter_var($requestArray[$input], $rule, $options);
        }
        
        return $requestArray;
    }
    
}
