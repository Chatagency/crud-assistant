<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Countable;
use Exception;
use Traversable;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;

/**
 * Input Collection Class.
 */
class InputCollection extends Input implements InputInterface, InputCollectionInterface, IteratorAggregate, Countable
{
    protected array $inputsArray = [];

    protected array $partialCollection = [];

    protected bool $prepare = true;

    protected bool $cleanup = true;

    public function setInputs(array $inputsArray)
    {
        foreach ($inputsArray as $input) {
            $this->addInput($input);
        }

        return $this;
    }

    public function addInput(InputInterface $input, string $key = null)
    {
        $key = $key ?? $input->getName();

        $this->inputsArray[$key] = $input;

        return $this;
    }

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


    public function setPartialCollection(array $partialCollection)
    {
        if (!\count($partialCollection)) {
            throw new Exception('The array passed is empty', 500);
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

    public function getPartialCollection()
    {
        return $this->partialCollection;
    }

    public function count(): int
    {
        return \count($this->getInputs());
    }

    public function disablePrepare()
    {
        $this->prepare = false;

        return $this;
    }

    public function disableCleanup()
    {
        $this->cleanup = false;

        return $this;
    }

    public function isset(string $key)
    {
        return isset($this->inputsArray[$key]);
    }

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
     */
    public function getInputs(bool $all = false)
    {
        $partialCollection = $this->getPartialCollection();

        if (\count($partialCollection) && !$all) {
            return $partialCollection;
        }

        return $this->inputsArray;
    }

    public function getInputNames()
    {
        $names = [];

        foreach ($this->getInputs() as $input) {
            $names[] = $input->getName();
        }

        return $names;
    }

    public function getInputLabels()
    {
        $labels = [];

        foreach ($this->getInputs() as $input) {
            $labels[] = $input->getLabel();
        }

        return $labels;
    }

    public function execute(ActionInterface $action): DataContainerInterface
    {
        if ($action->controlsExecution()) {
            return $this->executeAll($action);
        }

        if ($this->prepare) {
            $action->prepare();
        }

        foreach ($this->getInputs() as $input) {

            $recipe = $input->getRecipe($action->getIdentifier());

            if ($recipe && $recipe->isIgnored()) {
                continue;
            }

            if (CrudAssistant::isInputCollection($input) && $action->controlsRecursion()) {
                $action->execute($input);
                continue;
            }

            if (CrudAssistant::isInputCollection($input)) {

                $input->disablePrepare()
                    ->disableCleanup();

                $input->execute($action);

                if ($action->processInternalCollection()) {
                    $action->execute($input);
                }

                continue;
            }

            $input->execute($action);
        }

        if ($this->cleanup) {
            $action->cleanup();
        }

        return $action->getOutput();
    }


    public function executeAll(ActionInterface $action): DataContainerInterface
    {
        $action->prepare();
        $action->execute($this);
        $action->cleanup();

        return $action->getOutput();
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->getInputs());
    }
}
