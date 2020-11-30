<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Data DataContainer Interface.
 */
interface DataContainerInterface
{
    /**
     * Construct can receive a data array.
     *
     * @return self
     */
    public function __construct(array $data = []);

    /**
     * Magic set method.
     */
    public function __get(string $name);

    /**
     * Magic set method.
     *
     * @param $value
     */
    public function __set(string $name, $value);

    /**
     * Magic isset method.
     *
     * @return bool
     */
    public function __isset(string $name);

    /**
     * Magic unset method.
     *
     * @return null
     */
    public function __unset(string $name);

    /**
     * To string method.
     *
     * @return string
     */
    public function __toString();

    /**
     * Fills the container. It replaces
     * the current data array with
     * the one provided.
     *
     * @return self
     */
    public function fill(array $data);

    /**
     * Verifies that all keys in an
     * array are set.
     *
     * @return bool
     */
    public function contains(array $keys);

    /**
     * Verifies if any of the keys
     * in an array is missing in
     * the container. Returns
     * first missing key.
     *
     * @return bool|string
     */
    public function missing(array $keys);

    /**
     * Returns the data array.
     *
     * @return array
     */
    public function all();

    /**
     * Offset set.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value);

    /**
     * Offset exists.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetExists($offset);

    /**
     * Offset unset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset);

    /**
     * Offset set get.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetGet($offset);
}
