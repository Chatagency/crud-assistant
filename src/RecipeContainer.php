<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Exception;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Contracts\RecipeInterface;

/**
 * the recipe class stores input
 * information and instructions
 * for the action.
 */
abstract class RecipeContainer extends DataContainer implements RecipeInterface
{
    use RecipeTrait;

    /**
     * Allowed setters.
     * Ignored if empty.
     *
     * @var array
     */
    protected $setters = [];

    /**
     * {@inheritdoc}
     */
    public function __set(string $name, $value): void
    {
        $this->validateSetter($name);

        parent::__set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function fill(array $data): static
    {
        $this->validateSetters($data);

        return parent::fill($data);
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $data): static
    {
        $this->validateSetters($data);

        return parent::add($data);
    }


    public function validateSetters(array $data): static
    {
        foreach ($data as $setter => $value) {
            $this->validateSetter($setter);
        }

        return $this;
    }

    /**
     * Checks if a setter is valid.
     *
     * @param mixed $setter
     *
     * @return void
     */
    protected function validateSetter($setter): void
    {
        // Check if in setters array
        if (\count($this->setters) && !\in_array($setter, $this->setters)) {
            throw new Exception('The setter "'.$setter.'" is not available on this recipe', 500);
        }
    }
}
