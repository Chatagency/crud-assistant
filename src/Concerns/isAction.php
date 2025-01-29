<?php

namespace Chatagency\CrudAssistant\Concerns;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Contracts\ModifierInterface;

trait isAction
{

    protected $output;

    protected $controlsRecursion = false;

    protected $controlsExecution = false;

    protected $processInternalCollection = false;

    public function initOutput()
    {
        if(!$this->output) {
            $this->output = new DataContainer();
        }
        
        return $this;
    }

    public static function getIdentifier()
    {
        return Static::class;
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
        return $this->controlsRecursion;
    }

    public function controlsExecution()
    {
        return $this->controlsExecution;
    }

    public function processInternalCollection()
    {
        return $this->processInternalCollection;
    }

    public function isEmpty($value)
    {
        return $value === '' || $value === null;
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

    public function getOutput(): DataContainer
    {
        $this->initOutput();
        
        return $this->output;
    }
}
