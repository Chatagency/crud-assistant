<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use ArrayIterator;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Countable;
use IteratorAggregate;
use ArrayAccess;

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
        $this->data = $data;

        return $this;
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

    public function __toString()
    {
        return json_encode($this->data);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Implement countable interface.
     *
     * @return int
     */
    public function count()
    {
        return \count($this->data);
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
     * first key missing.
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
    public function all()
    {
        return $this->data;
    }

    public function offsetSet($offset, $value) {        
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset) {
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
