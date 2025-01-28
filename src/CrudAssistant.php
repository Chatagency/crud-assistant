<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use BadMethodCallException;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;

/**
 * Crud Assistant Manager.
 */
final class CrudAssistant
{
    /**
     * Input collection.
     *
     * @var InputCollectionInterface
     */
    protected $collection;

    /**
     * Construct.
     *
     * @return self
     */
    public function __construct(array $inputs = [], string $name = null, string $label = null, InputCollectionInterface $collection = null)
    {
        $this->collection = $collection ?? new InputCollection($name, $label);
        $this->collection->setInputs($inputs);
    }

    /**
     * Magic call method class tied
     * to the input collection.
     *
     * @param $name
     * @param $arguments
     *
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // Check if the method called is a collection method.
        if (method_exists($this->collection, $name)) {
            $object_array = [$this->collection, $name];

            return \call_user_func_array($object_array, $arguments);
        }

        throw new BadMethodCallException('Method '.$name.' not exists in '.static::class, 500);
    }

    public static function make(array $inputs = [], string $name = null, string $label = null, InputCollectionInterface $collection = null)
    {
        return (new static($inputs, $name, $label, $collection))->getCollection();
    }

    /**
     * Returns input collection.
     *
     * @return InputCollectionInterface
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Verifies if object is an input collection.
     *
     * @return bool
     */
    public static function isInputCollection(InputInterface $input)
    {
        return is_a($input, InputCollectionInterface::class);
    }

    /**
     * Verifies if an object id a closure
     *
     * @param $instance
     * @return boolean
     */
    public static function isClosure($instance) {
        return $instance instanceof \Closure;
    }
}
