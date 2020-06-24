<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\DataContainer;

/**
 * Input Collection Interface.
 */
interface InputCollectionInterface
{
    /**
     * Constructor.
     *
     * @return self
     */
    public function __construct(array $inputsArray, ActionFactory $actionFactory = null);

    /**
     * Adds input to the array.
     *
     * @param string $key
     *
     * @return self
     */
    public function addInput(InputInterface $input, string $key = null);

    /**
     * Removes input from the array if exists.
     *
     * @return self
     */
    public function removeInput(string $key);

    /**
     * Returns inputs array count.
     *
     * @return int
     */
    public function count();

    /**
     * Returns inputs array.
     *
     * @throws InvalidArgumentException
     *
     * @return InputInterface
     */
    public function getInput(string $key);

    /**
     * Returns inputs array.
     *
     * @return array
     */
    public function getInputs();

    /**
     * Returns Input Names.
     *
     * @return array
     */
    public function getInputNames();

    /**
     * Execute actions.
     * 
     * @param ActionInterface $action
     *
     * @return DataContainer
     * 
     */
    public function execute(ActionInterface $action);
}
