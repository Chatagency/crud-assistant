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
class SanitationAction extends Action implements ActionInterface
{
    /**
     * Output has been prepared
     *
     * @var boolean
     */
    protected $prepared = false;
    
    /**
     * Pre Execution.
     *
     * @return DataContainerInterface
     */
    public function prepare(DataContainerInterface $output)
    {
        $params = $this->getParams();
        $output->requestArray = $params->requestArray;
        $this->checkRequiredParams($params, ['requestArray']);

        $this->prepared = true;

        return $output;
        
    }
    
    /**
     * Execute action on input.
     *
     * @return DataContainerInterface
     */
    public function execute(InputInterface $input, DataContainerInterface $output)
    {
        if (!$this->prepared) {
            $output = $this->prepare($output);
        }

        $recipe = $input->getRecipe(static::class);
        $requestArray = $output->requestArray;
        $inputName = $input->getName();
        $type = $recipe->type ?? null;

        if (isset($requestArray[$inputName]) && $type) {
            if (\is_array($type)) {
                $requestArray[$inputName.'_raw'] = $requestArray[$inputName];
                foreach ($type as $filter) {
                    $id = $filter['id'] ?? null;
                    $options = $filter['options'] ?? [];
                    $requestArray = $this->applyFilter($inputName, $id, $requestArray, $options);
                }
            } else {
                $requestArray = $this->applyFilter($inputName, $type, $requestArray);
            }
        }

        $output->requestArray = $requestArray;

        return $output;
    }

    /**
     * Applies Filter.
     *
     * @param mixed $id
     *
     * @return array
     */
    protected function applyFilter(string $inputName, $id, array $requestArray, array $options = [])
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
