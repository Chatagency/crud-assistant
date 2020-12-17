<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\RecipeInterface;
use Exception;

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
    public function __set(string $name, $value)
    {
        $this->validateSetter($name);

        return parent::__set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function fill(array $data)
    {
        $this->validateSetters($data);

        return parent::fill($data);
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $data)
    {
        $this->validateSetters($data);

        return parent::add($data);
    }

    /**
     * Validates if a key/value
     * array has valid setters.
     *
     * @return void
     */
    public function validateSetters(array $data)
    {
        foreach ($data as $setter => $value) {
            $this->validateSetter($setter);
        }
    }

    /**
     * Checks if a setter is valid.
     *
     * @param mixed $setter
     *
     * @return void
     */
    protected function validateSetter($setter)
    {
        // Check if in setters array
        if (!empty($this->setters) && !\in_array($setter, $this->setters)) {
            throw new Exception('The setter "'.$setter.'" is not available on this recipe', 500);
        }
    }
}
