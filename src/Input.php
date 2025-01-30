<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionInterface;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * Input Base Class.
 */
abstract class Input implements InputInterface
{
    protected string|null $name;

    protected string|null $label;

    protected int|null $version = 1;

    protected array $attributes = [];

    protected InputCollectionInterface $subElements;

    protected string|null $type = null;

    protected array $recipes = [];

    public function __construct(string $name = null, string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? $name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function setAttribute(string $name, $value): static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function setSubElements(InputCollectionInterface $subElements): static
    {
        $this->subElements = $subElements;

        return $this;
    }

    public function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getType(): string|null
    {
        return $this->type;
    }

    public function getAttribute(string $name): mixed
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function unsetAttribute(string $key): static
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }


    public function getSubElements(): InputCollectionInterface
    {
        return $this->subElements;
    }


    public function setRecipe(RecipeInterface $recipe): static
    {
        $this->recipes[$recipe->getIdentifier()] = $recipe;

        return $this;
    }

    public function getRecipe(string $recipe): RecipeInterface|null
    {
        if (isset($this->recipes[$recipe])) {
            return $this->recipes[$recipe];
        }

        return null;
    }


    public function execute(ActionInterface $action): DataContainerInterface
    {
        return $action->execute($this);
    }
}
