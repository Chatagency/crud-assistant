<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use ArrayIterator;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Countable;
use Exception;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * Input Collection Class.
 */
class InputCollection extends Input implements InputCollectionInterface, IteratorAggregate, Countable
{
    /**
     * Inputs array.
     *
     * @var array
     */
    protected $inputsArray = [];

    /**
     * Partial Inputs.
     *
     * @var array
     */
    protected $partialCollection = [];

    /**
     * Action Factory.
     *
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Sets inputs array.
     *
     * @return self
     */
    public function setInputs(array $inputsArray)
    {
        foreach ($inputsArray as $input) {
            $this->addInput($input);
        }

        return $this;
    }

    /**
     * Adds input to the array.
     *
     * @param string $key
     *
     * @return self
     */
    public function addInput(InputInterface $input, string $key = null)
    {
        $key = $key ?? $input->getName();

        $this->inputsArray[$key] = $input;

        return $this;
    }

    /**
     * Removes input from the array if exists.
     *
     * @return self
     */
    public function removeInput(string $key)
    {
        if (isset($this->inputsArray[$key])) {
            unset($this->inputsArray[$key]);
        }
        if (isset($this->partialCollection[$key])) {
            unset($this->partialCollection[$key]);
        }

        return $this;
    }

    /**
     * Sets the array of partial inputs.
     *
     * @throws Exception
     *
     * @return self
     */
    public function setPartialCollection(array $partialCollection)
    {
        if (!\count($partialCollection)) {
            throw new Exception('The array passed to '.__METHOD__.' is empty', 500);
        }

        $inputs = $this->getInputs();

        if (!\count($inputs)) {
            throw new Exception('This collection cannot add partial inputs because it has no inputs', 500);
        }

        foreach ($partialCollection as $inputName) {
            $this->partialCollection[$inputName] = $this->getInput($inputName);
        }

        return $this;
    }

    /**
     * Returns the array of partial inputs.
     *
     * @return array
     */
    public function getPartialCollection()
    {
        return $this->partialCollection;
    }

    /**
     * Returns inputs array count.
     *
     * @return int
     */
    public function count()
    {
        return \count($this->getInputs());
    }

    /**
     * Checks if input exists.
     *
     * @return bool
     */
    public function isset(string $key)
    {
        return isset($this->inputsArray[$key]);
    }

    /**
     * Returns inputs array.
     *
     * @throws InvalidArgumentException
     *
     * @return InputInterface
     */
    public function getInput(string $key)
    {
        if (isset($this->inputsArray[$key])) {
            return $this->inputsArray[$key];
        }

        throw new InvalidArgumentException('The '.$key.' Input has not been registered or does not exist', 500);
    }

    /**
     * Returns inputs array.
     * If partial inputs have been set
     * it returns partial inputs.
     *
     * @return array
     */
    public function getInputs(bool $all = false)
    {
        $partialCollection = $this->getPartialCollection();

        if (\count($partialCollection) && !$all) {
            return $partialCollection;
        }

        return $this->inputsArray;
    }

    /**
     * Returns Input Names.
     *
     * @return array
     */
    public function getInputNames()
    {
        $names = [];

        foreach ($this->getInputs() as $input) {
            $names[] = $input->getName();
        }

        return $names;
    }

    /**
     * Returns Input Labels.
     *
     * @return array
     */
    public function getInputLabels()
    {
        $labels = [];

        foreach ($this->getInputs() as $input) {
            $labels[] = $input->getLabel();
        }

        return $labels;
    }

    /**
     * Executes Action.
     *
     * @param DataContainer $output
     *
     * @return DataContainer
     */
    public function execute(ActionInterface $action, DataContainerInterface $output = null)
    {
        if ($action->controlsExecution()) {
            return $this->executeAll($action, $output);
        }

        $output = $output ?? new DataContainer();
        $output = $action->prepare($output);

        foreach ($this->getInputs() as $input) {
            if (CrudAssistant::isInputCollection($input) && $action->isTree()) {
                
                $collectionName = $input->getName();

                if (!$collectionName) {
                    throw new Exception('All internal collections must have a name', 500);
                }
                $dataContainerClass = \get_class($output);
                $output->$collectionName = $input->execute($action, new $dataContainerClass());

                continue;
            }

            $input->execute($action, $output);
        }

        $output = $action->cleanup($output);

        return $output;
    }

    /**
     * Pass whole collection to the action.
     *
     * @param DataContainer $output
     *
     * @return DataContainer
     */
    public function executeAll(ActionInterface $action, DataContainerInterface $output = null)
    {
        $output = $output ?? new DataContainer();

        $output = $action->prepare($output);
        $output = $action->execute($this, $output);
        return $action->cleanup($output);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getInputs());
    }
}
