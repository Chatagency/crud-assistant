<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use InvalidArgumentException;

/**
 * Action base class.
 */
abstract class Action
{
    /**
     * Data.
     *
     * @var DataContainerInterface
     */
    protected $params;

    /**
     * Construct.
     *
     * @param DataContainerInterface $params
     */
    public function __construct(DataContainerInterface $params = null)
    {
        $this->params = $params ?? new DataContainer();

        return $this;
    }

    /**
     * Returns runtime args
     *
     * @return DataContainerInterface
     */
    protected function getParams()
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
    protected function ignore($recipe)
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
    protected function checkRequiredParams(DataContainerInterface $data, array $checks)
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

        $modifiers = $recipe['modifiers'] ?? null;

        if (\is_array($modifiers)) {
            foreach ($modifiers as $modifier) {
                $value = $this->executeModifier($modifier, $value, $model);
            }
        }

        return $value;
    }

    /**
     * Executes single modifier.
     *
     * @param $value
     * @param mixed $model
     *
     * @return mixed
     */
    protected function executeModifier(Modifier $modifier, $value, $model = null)
    {
        return $modifier->modify($value, $modifier->getData(), $model);
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
