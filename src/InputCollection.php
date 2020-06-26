<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use InvalidArgumentException;
use Exception;

/**
 * Input Collection Class.
 */
class InputCollection implements InputCollectionInterface
{
    /**
     * Inputs array.
     *
     * @var array
     */
    protected $inputsArray = [];

    /**
     * Partial Inputs
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
     * Constructor.
     *
     * @return self
     */
    public function __construct(array $inputsArray, ActionFactory $actionFactory = null)
    {
        foreach($inputsArray as $input) {
            $this->addInput($input);
        }
        
        $this->actionFactory = $actionFactory ?? new ActionFactory();

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
     * Sets the array of partial inputs
     *
     * @param array $partialCollection
     * 
     * @return self
     * 
     * @throws Exception
     */
    public function setPartialCollection(array $partialCollection)
    {
        if(empty($partialCollection)) {
            throw new Exception("The array passed to ".__METHOD__. " is empty", 500);
        }
        
        $inputs = $this->getInputs();
        
        if(empty($inputs)) {
            throw new Exception("This collection cannot add partial inputs because it has no inputs", 500);
        }

        foreach($partialCollection as $inputName) {
            $this->partialCollection[$inputName] = $this->getInput($inputName);
        }

        return $this;

    }

    /**
     * Returns the array of partial inputs
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
        return \count($this->inputsArray);
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
     * it returns partial inputs
     * 
     * @param bool $all
     *
     * @return array
     */
    public function getInputs(bool $all = false)
    {
        $partialCollection = $this->getpartialCollection();

        if(!empty($partialCollection) && !$all) {
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

        foreach ($this->getInputs() as $key => $input) {
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

        foreach ($this->getInputs() as $key => $input) {
            $labels[] = $input->getLabel();
        }

        return $labels;
    }

    /**
     * Execute actions.
     */
    public function execute(ActionInterface $action)
    {
        return $action->execute($this->getInputs());
    }
}
