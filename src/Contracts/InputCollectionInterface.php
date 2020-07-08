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
     * Sets inputs array.
     *
     * @param array $inputsArray
     * @return self
     */
    public function setInputs(array $inputsArray);

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
     * Sets the array of partial inputs.
     *
     * @throws Exception
     *
     * @return self
     */
    public function setPartialCollection(array $partialCollection);

    /**
     * Returns the array of partial inputs.
     *
     * @return array
     */
    public function getPartialCollection();

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
     * If partial inputs have been set
     * it returns partial inputs.
     *
     * @return array
     */
    public function getInputs(bool $all = false);

    /**
     * Returns Input Names.
     *
     * @return array
     */
    public function getInputNames();

    /**
     * Returns Input Labels.
     *
     * @return array
     */
    public function getInputLabels();

    /**
     * Execute actions.
     */
    public function execute(ActionInterface $action);
}
