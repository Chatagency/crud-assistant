<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Action base class.
 */
abstract class Action
{
    /**
     * Generic Data.
     *
     * @var DataContainerInterface
     */
    protected $genericData;

    /**
     * Output.
     *
     * @var DataContainerInterface
     */
    protected $output;

    /**
     * Controls recursion
     *
     * @var bool
     */
    protected $controlsRecursion = false;

    /**
     * Action control the
     * whole execution.
     *
     * @var bool
     */
    protected $controlsExecution = false;

    /**
     * Process internal collection
     *
     * @var boolean
     */
    protected $processInternalCollection = false;

    /**
     * Creates new instance of the class.
     *
     * @return static
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }

    /**
     * Initialize output
     *
     * @return static
     */
    public function initOutput()
    {
        if(!$this->output) {
            $this->output = new DataContainer();
        }
        
        return $this;
    }

    /**
     * Returns recipe accessor
     *
     * @return string
     */
    public static function getIdentifier()
    {
        return Static::class;
    }

    /**
     * Sets generic set genericData.
     *
     * @param DataContainerInterface $genericData
     * 
     * @return static
     */
    public function setGenericData(DataContainerInterface $genericData)
    {
        $this->genericData = $genericData;

        return $this;
    }

    /**
     * Set controls recursion.
     *
     * @param bool  $controlsRecursion
     *
     * @return static
     */ 
    public function setControlsRecursion(bool $controlsRecursion)
    {
        $this->controlsRecursion = $controlsRecursion;

        return $this;
    }

    /**
     * Set processed
     *
     * @param bool $processInternalCollection processed
     *
     * @return static
     */ 
    public function setProcessInternalCollection(bool $processInternalCollection)
    {
        $this->processInternalCollection = $processInternalCollection;

        return $this;
    }

    /**
     * Returns generic set genericData.
     *
     * @return DataContainerInterface
     */
    public function getGenericData()
    {
        return $this->genericData;
    }

    /**
     * Pre Execution.
     *
     * @return self
     */
    public function prepare()
    {
        return $this;
    }

    /**
     * Post Execution.
     *
     * @return self
     */
    public function cleanup()
    {
        return $this;
    }

    /**
     * Notifies the collection the action
     * controls the recursion for of
     * inner collection.
     *
     * @return bool
     */
    public function controlsRecursion()
    {
        return $this->controlsRecursion;
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
     * Process an internal input collection
     * the same way a regular input is
     * processed
     *
     * @return  boolean
     */ 
    public function processInternalCollection()
    {
        return $this->processInternalCollection;
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
        return $modifier->modify($value, $model);
    }

    /**
     * Returns output
     *
     * @return DataContainerInterface
     */
    public function getOutput()
    {
        $this->initOutput();
        
        return $this->output;
    }
}
