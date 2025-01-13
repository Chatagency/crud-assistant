<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\Recipe;

/**
 * Input Collection Interface.
 */
interface InputInterface
{
    public function setName(string $name): static;
  
    public function setLabel(string $label): static;

    public function setAttribute(string $name, $value): static;

    public function setSubElements(InputCollectionInterface $subElements): static;

    public function setVersion(int $version): static;

    public function setType(string $type): static;

    public function getName(): string;

    public function getLabel(): string;

    public function getVersion(): int;

    public function getType():string|null;


    public function getAttribute(string $name): mixed;

 
    public function getAttributes(): array;

    public function unsetAttribute(string $key): static;


    public function getSubElements(): InputCollectionInterface;

    public function setRecipe(RecipeInterface $recipe): static;

    public function getRecipe(string $recipe): RecipeInterface|null;


    public function execute(ActionInterface $action): DataContainerInterface;
}
