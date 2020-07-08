<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Sanitation action.
 */
class Sanitation extends Action implements ActionInterface
{
    /**
     * Execute action on input
     *
     * @param InputInterface $input
     * @param DataContainerInterface $output
     * 
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        $params = $params ?? $this->getParams();

        $this->checkRequiredParams($params, ['requestArray']);

        $rule = $input->getRecipe(static::class);
        $requestArray = $params->requestArray;
        $name = $input->getName();
      
        if (isset($requestArray[$input])) {
            if (\is_array($rule) && isset($rule['rules']) && \is_array($rule['rules'])) {
                $options = isset($rule['options']) && \is_array($rule['options']) ? $rule['options'] : [];
                foreach ($rule['rules'] as $val) {
                    $requestArray = $this->applyFilter($name, $val, $requestArray, $options);
                }
                $requestArray[$name.'_raw'] = $requestArray[$name];
            } else {
                $requestArray = $this->applyFilter($name, $rule, $requestArray);
            }
        }
        
        return $requestArray;
    }

    /**
     * Applies Filter.
     *
     * @return array
     */
    protected function applyFilter(string $input, int $rule, array $requestArray, array $options = [])
    {
        if (\is_array($requestArray[$input])) {
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
