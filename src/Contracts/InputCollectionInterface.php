<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Exception;

/**
 * Input Collection Interface.
 */
interface InputCollectionInterface
{

    public function setInputs(array $inputsArray);

    public function addInput(InputInterface $input, string $key = null);

    public function removeInput(string $key);

    public function setPartialCollection(array $partialCollection);

    public function getPartialCollection();

    public function count();

    public function isset(string $key);

    public function getInput(string $key);

    public function getInputs(bool $all = false);

    public function getInputNames();

    public function getInputLabels();

    public function execute(ActionInterface $action);
    
    public function executeAll(ActionInterface $action);
}
