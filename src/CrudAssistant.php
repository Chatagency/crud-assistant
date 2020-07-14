<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use BadMethodCallException;

/**
 * Crud Assistant Manager.
 */
class CrudAssistant
{
    /**
     * Input collection.
     *
     * @var InputCollection
     */
    protected $collection;

    /**
     * Construct.
     *
     * @return self
     */
    public function __construct(array $inputs = [])
    {
        $this->collection = new InputCollection();
        $this->collection->setInputs($inputs);

        return $this;
    }

    /**
     * Magic call method class tied
     * to collection and actions.
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

        throw new BadMethodCallException('Method '.$name.' not exists in '.__CLASS__, 500);
    }

    /**
     * Creates new instance of this class.
     *
     * @return self
     */
    public static function make(... $args)
    {
        return new static(... $args);
    }

    /**
     * Returns input collection.
     *
     * @return InputCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
