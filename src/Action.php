<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
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
     * Result is a tree instead
     * of flat.
     *
     * @var bool
     */
    protected $isTree = false;

    /**
     * Action control the
     * whole execution.
     *
     * @var bool
     */
    protected $controlsExecution = false;

    /**
     * Construct.
     *
     * @param DataContainerInterface $params
     */
    public function __construct(DataContainerInterface $params = null)
    {
        $this->params = $params ?? new DataContainer();

        foreach ($this->params as $name => $param) {
            $this->$name = $param;
        }

        return $this;
    }

    /**
     * Creates new instance of the class.
     *
     * @param array $args
     *
     * @return ActionInterface
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }

    /**
     * Pre Execution.
     *
     * @return DataContainerInterface
     */
    public function prepare(DataContainerInterface $output)
    {
        return $output;
    }

    /**
     * Post Execution.
     *
     * @return DataContainerInterface
     */
    public function cleanup(DataContainerInterface $output)
    {
        return $output;
    }

    /**
     * Notifies the collection the output
     * result must be in a tree format
     * instead of a flat output.
     *
     * @return bool
     */
    public function isTree()
    {
        return $this->isTree;
    }

    /**
     * Notifies the collection the action
     * will take control of the whole
     * execution. This triggers the
     * method executeAll().
     *
     * @return bool
     */
    public function controlsExecution()
    {
        return $this->controlsExecution;
    }

    /**
     * Checks if the value is empty.
     *
     * @param $value
     *
     * @return bool
     */
    public function isEmpty($value)
    {
        return $value === '' || $value === null;
    }

    /**
     * Returns runtime args.
     *
     * @return DataContainerInterface
     */
    protected function getParams()
    {
        return $this->params;
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

        if (!$recipe) {
            return $value;
        }

        $modifiers = $recipe->getModifiers() ?? null;

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
}
