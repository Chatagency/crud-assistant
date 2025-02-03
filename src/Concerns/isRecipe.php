<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Concerns;

use Chatagency\CrudAssistant\Contracts\ModifierInterface;

/**
 * Recipe Trait.
 */
trait isRecipe
{
    // protected ?string $action = null;

    protected $ignored = false;

    protected $modifiers = [];

    public function getIdentifier(): string
    {
        if (isset($this->action)) {
            return ($this->action)::getIdentifier();
        }

        return static::class;
    }

    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    public function setModifier(ModifierInterface $modifier)
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    public function setModifiers(array $modifiers)
    {
        foreach ($modifiers as $modifier) {
            $this->setModifier($modifier);
        }

        return $this;
    }

    public function getModifiers()
    {
        return $this->modifiers;
    }

    public function hasModifiers()
    {
        return (bool) \count($this->getModifiers());
    }

    public function isIgnored()
    {
        return $this->ignored;
    }
}
