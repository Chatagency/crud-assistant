<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
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
     * @param ActionFactory $actionFactory
     *
     * @return self
     */
    public function __construct(array $inputsArray = [], ActionFactory $actionFactory = null)
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
    public function add(InputInterface $input, string $key = null)
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
    public function remove(string $key)
    {
        if (isset($this->inputsArray[$key])) {
            unset($this->inputsArray[$key]);
        }

        return $this;
    }

    /**
     * Retruns inputs array count.
     *
     * @return int
     */
    public function count()
    {
        return count($this->inputsArray);
    }

    /**
     * Returns inputs array.
     *
     * @return InputInterface
     *
     * @throws InvalidArgumentException
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
     * @param $params
     *
     * @return mixed
     */
    public function execute(string $type, $params = null)
    {
        return $this->getActionInstace($type)->execute($this->inputsArray, $params);
    }

    /**
     * Returns action type instance.
     *
     * @return ActionInterface
     */
    protected function getActionInstace(string $type)
    {
        return $this->actionFactory->getInstanse($type);
    }
}
