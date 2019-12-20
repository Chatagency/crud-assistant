<?php

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
     * @param array $inputsArray
     * @param ActionFactory $actionFactory
     *
     * @return self
     */
    public function __construct(array $inputsArray = [], ActionFactory $actionFactory);

    /**
     * Adds input to the array.
     *
     * @param InputInterface $input
     * @param string $key
     *
     * @return self
     */
    public function addInput(InputInterface $input, string $key = null);

    /**
     * Removes input from the array if exists.
     *
     * @param string $key
     *
     * @return self
     */
    public function removeInput(string $key);

    /**
     * Retruns inputs array count.
     *
     * @return int
     */
    public function count();

    /**
     * Returns inputs array.
     *
     * @param string $key
     *
     * @return InputInterface
     *
     * @throws InvalidArgumentException
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
     * @param string $type
     * @param DataContainer $params
     *
     * @return mixed
     */
    public function execute(string $type, DataContainer $params = null);
}
