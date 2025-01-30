<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Crud Assistant Manager.
 */
final class CrudAssistant
{
    private InputCollectionInterface $collection;

    public function __construct(array $inputs = [], ?string $name = null, ?string $label = null, ?InputCollectionInterface $collection = null)
    {
        $this->collection = $collection ?? new InputCollection($name, $label);
        $this->collection->setInputs($inputs);
    }

    public static function make(array $inputs = [], ?string $name = null, ?string $label = null, ?InputCollectionInterface $collection = null): InputCollectionInterface
    {
        return (new self($inputs, $name, $label, $collection))->getCollection();
    }

    public function getCollection(): InputCollectionInterface
    {
        return $this->collection;
    }

    public static function isInputCollection(InputInterface $input): bool
    {
        return is_a($input, InputCollectionInterface::class);
    }

    public static function isClosure($instance): bool
    {
        return $instance instanceof \Closure;
    }
}
