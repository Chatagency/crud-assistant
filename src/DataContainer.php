<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

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
    }

    /**
     * Creates new instance of the class.
     *
     * @param array $args
     *
     * @return static
     */
    public static function make(array $data = [])
    {
        return (new static($data));
    }


    public function __get(string $name): mixed
    {
        if (!\array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$name];
    }

    /**
     * Magic set method.
     *
     * @param $value
     */
    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    /**
     * Magic isset method.
     *
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Magic unset method.
     *
     * @return null
     */
    public function __unset(string $name): void
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
    public function fill(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Adds values to the data array.
     *
     * @return self
     */
    public function add(array $data): static
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
    public function push($value): static
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
    public function contains(array $keys): bool
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
    public function missing(array $keys): mixed
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
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * toArray() method alias.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->toArray();
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    public function count(): int
    {
        return \count($this->data);
    }

    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function offsetGet($offset): mixed
    {
        if (!\array_key_exists($offset, $this->data)) {
            throw new InvalidArgumentException();
        }

        return $this->data[$offset];
    }
}
