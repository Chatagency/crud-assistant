<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use ArrayAccess;
use ArrayIterator;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Countable;
use IteratorAggregate;

/**
 * DataContainer.
 */
class DataContainer implements DataContainerInterface, IteratorAggregate, Countable, ArrayAccess
{
    /**
     * Arbitrary data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Construct can receive a data array.
     *
     * @return self
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);

        return $this;
    }

    /**
     * Creates new instance of the class.
     *
     * @param array $args
     *
     * @return static
     */
    public static function make(...$args)
    {
        return (new static(...$args));
    }

    /**
     * Magic set method.
     */
    public function __get(string $name)
    {
        if (!\array_key_exists($name, $this->data)) {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): '.$name.
                ' in '.$trace[0]['file'].
                ' on line '.$trace[0]['line'],
                E_USER_NOTICE
            );
        }

        return $this->data[$name];
    }

    /**
     * Magic set method.
     *
     * @param $value
     */
    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Magic isset method.
     *
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Magic unset method.
     *
     * @return null
     */
    public function __unset(string $name)
    {
        unset($this->data[$name]);
    }

    /**
     * To string method.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->data);
    }

    /**
     * Fills the container. It replaces
     * the current data array with
     * the one provided.
     *
     * @return self
     */
    public function fill(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Adds values to the data array.
     *
     * @return self
     */
    public function add(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Pushes a value to the data array.
     *
     * @param mixed $value
     * @return self
     */
    public function push($value)
    {
        array_push($this->data, $value);

        return $this;
    }

    /**
     * Verifies that all keys in an
     * array are set.
     *
     * @return bool
     */
    public function contains(array $keys)
    {
        foreach ($keys as $key) {
            if (!isset($this->data[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verifies if any of the keys
     * in an array is missing in
     * the container. Returns
     * first missing key.
     *
     * @return bool|string
     */
    public function missing(array $keys)
    {
        foreach ($keys as $key) {
            if (!isset($this->data[$key])) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Returns the data array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * toArray() method alias.
     *
     * @return array
     */
    public function all()
    {
        return $this->toArray();
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Implement countable interface.
     *
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function count()
    {
        return \count($this->data);
    }

    /**
     * Offset set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Offset exists.
     *
     * @param mixed $offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Offset unset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * Offset set get.
     *
     * @param mixed $offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (!\array_key_exists($offset, $this->data)) {
            $trace = debug_backtrace();
            trigger_error(
                'Undefined property via __get(): '.$offset.
                ' in '.$trace[0]['file'].
                ' on line '.$trace[0]['line'],
                E_USER_NOTICE
            );
        }

        return $this->data[$offset];
    }
}
