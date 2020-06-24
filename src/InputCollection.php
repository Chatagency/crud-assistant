<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\DataContainer;
use InvalidArgumentException;

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
        $this->inputsArray = array_merge($this->inputsArray, $inputsArray);
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

        return $this;
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
     *
     * @return array
     */
    public function getInputs()
    {
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
     * Execute actions.
     * 
     * @param ActionInterface $action
     *
     * @return DataContainer
     * 
     */
    public function execute(ActionInterface $action)
    {
        return $action->execute($this->inputsArray);
    }

}
