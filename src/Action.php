<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use InvalidArgumentException;

/**
 * Action base class.
 */
abstract class Action
{
    /**
     * Data
     *
     * @var DataContainerInterface
     */
    protected $params;
    
    /**
     * Construct
     *
     * @param DataContainerInterface $params
     */
    public function __construct(DataContainerInterface $params = null)
    {
        $this->params = $params ?? new DataContainer();

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }
    
    /**
     * Checks for value is to be ignored.
     *
     * @param $recipe
     *
     * @return bool
     */
    public function ignore($recipe)
    {
        if (!\is_array($recipe)) {
            return false;
        }

        return $recipe['ignore'] ?? false;
    }

    /**
     * Ignore if value is empty.
     *
     * @param $value
     * @param $recipe
     *
     * @return bool
     */
    protected function ignoreIfEmpty($value, $recipe)
    {
        if (!\is_array($recipe)) {
            return false;
        }

        if (!$this->isEmpty($value)) {
            return false;
        }

        return $recipe['ignoreIfEmpty'] ?? false;
    }

    /**
     * Checks params integrity.
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    protected function checkRequiredParams(DataContainer $data, array $checks)
    {
        if ($missing = $data->missing($checks)) {
            throw new InvalidArgumentException('The argument '.$missing.' is missing for the '.static::class.' action', 500);
        }

        return true;
    }

    /**
     * Applies all modifiers to the a value.
     *
     * @param $value
     * @param mixed|null $model
     *
     * @return mixed
     */
    protected function modifiers($value, InputInterface $input, $model = null)
    {
        $recipe = $input->getRecipe(static::class);

        if (!\is_array($recipe)) {
            return $value;
        }

        $modifiers = $recipe['modifiers'] ?? [];

        if (\is_array($modifiers)) {
            foreach ($modifiers as $modifier => $data) {
                if (is_a($data, Modifier::class)) {
                    $value = $data->modify($value, $data->getData(), $model);
                    continue;
                }
                $value = (ModifierFactory::make($modifier))->modify($value, $data, $model);
            }
        }

        return $value;
    }

    /**
     * Checks if the value is empty.
     *
     * @param $value
     *
     * @return bool
     */
    protected function isEmpty($value)
    {
        return '' == $value || null === $value;
    }
}
