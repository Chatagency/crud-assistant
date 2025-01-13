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
abstract class RecipeBase implements RecipeInterface
{
    use RecipeTrait;

    /**
     * Construct can receive a data array.
     *
     * @return self
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

    }

    /**
     * Disable public attribute setting.
     *
     * @param mixed $value
     */
    public function __set(string $name, $value)
    {
        throw new Exception('The setter "'.$name.'" is not available on this recipe', 500);
    }
}
