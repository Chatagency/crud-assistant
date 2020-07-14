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
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input)
    {
        $params = $this->getParams();
        $output = $this->output;

        if (!isset($output->requestArray)) {
            $output->requestArray = $params->requestArray;
        }

        $this->checkRequiredParams($params, ['requestArray']);

        $recipe = $input->getRecipe(static::class);
        $requestArray = $output->requestArray;
        $inputName = $input->getName();

        if (isset($requestArray[$inputName]) && $recipe) {
            if (\is_array($recipe)) {
                $requestArray[$inputName.'_raw'] = $requestArray[$inputName];
                foreach ($recipe as $filter) {
                    $id = $filter['id'] ?? null;
                    $options = $filter['options'] ?? [];
                    $requestArray = $this->applyFilter($inputName, $id, $requestArray, $options);
                }
            } else {
                $requestArray = $this->applyFilter($inputName, $recipe, $requestArray);
            }
        }

        $output->requestArray = $requestArray;

        return $output;
    }

    /**
     * Applies Filter.
     *
     * @return array
     */
    protected function applyFilter(string $inputName, int $id, array $requestArray, array $options = [])
    {
        if (\is_array($requestArray[$inputName])) {
            foreach ($requestArray[$inputName] as $key => $singleInput) {
                $requestArray[$inputName.'_raw'][$key] = $singleInput;
                $requestArray[$inputName][$key] = filter_var($singleInput, $id, $options);
            }
        } else {
            $requestArray[$inputName.'_raw'] = $requestArray[$inputName];
            $requestArray[$inputName] = filter_var($requestArray[$inputName], $id, $options);
        }

        return $requestArray;
    }
}
