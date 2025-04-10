<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Concerns;

use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\ModifierInterface;
use Chatagency\CrudAssistant\DataContainer;

trait IsAction
{
    protected $output;

    public function initOutput()
    {
        if (!$this->output) {
            $this->output = new DataContainer();
        }

        return $this;
    }

    public static function getIdentifier()
    {
        return static::class;
    }

    public function setControlsRecursion(bool $controlsRecursion)
    {
        $this->controlsRecursion = $controlsRecursion;

        return $this;
    }

    public function setProcessInternalCollection(bool $processInternalCollection)
    {
        $this->processInternalCollection = $processInternalCollection;

        return $this;
    }

    public function prepare(): static
    {
        return $this;
    }

    public function cleanup(): static
    {
        return $this;
    }

    public function controlsRecursion()
    {
        return $this->controlsRecursion ?? false;
    }

    public function controlsExecution()
    {
        return $this->controlsExecution ?? false;
    }

    public function processInternalCollection()
    {
        return $this->processInternalCollection ?? false;
    }

    public function isEmpty($value)
    {
        return $value === '' || $value === null;
    }

    public function getOutput(): DataContainer
    {
        $this->initOutput();

        return $this->output;
    }

    protected function modifiers($value, InputInterface $input, $model = null)
    {
        $recipe = $input->getRecipe(static::class);

        if (!$recipe) {
            return $value;
        }

        $modifiers = $recipe->getModifiers();

        foreach ($modifiers as $modifier) {
            $value = $this->executeModifier($modifier, $value, $model);
        }

        return $value;
    }

    protected function executeModifier(ModifierInterface $modifier, $value, $model = null)
    {
        return $modifier->modify($value, $model);
    }
}
