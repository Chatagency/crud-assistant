<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Actions;

use Chatagency\CrudAssistant\Action;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * Sanitation action.
 */
class Sanitation extends Action implements ActionInterface
{
    /**
     * Executes action.
     *
     * @param DataContainerInterface $params
     */
    public function execute(array $inputs, DataContainerInterface $params = null)
    {
        $params = $params ?? $this->getParams();

        $this->checkRequiredParams($params, ['requestArray']);

        $rules = $this->rules($inputs);
        $requestArray = $params->requestArray;

        foreach ($rules as $input => $rule) {
            if (isset($requestArray[$input])) {
                if (\is_array($rule) && isset($rule['rules']) && \is_array($rule['rules'])) {
                    $options = isset($rule['options']) && \is_array($rule['options']) ? $rule['options'] : [];
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
     * Returns rules array.
     *
     * @return array
     */
    protected function rules(array $inputs)
    {
        $rules = [];

        foreach ($inputs as $key => $input) {
            $recipe = $input->getRecipe(static::class);

            if ($this->ignore($recipe)) {
                continue;
            }

            $name = $input->getName();

            if ($recipe) {
                $rules[$name] = $recipe;
            }
        }

        return $rules;
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
