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
     * Verifies that all keys in an
     * array are set
     *
     * @param  array  $keys
     *
     * @return bool
     */
    public function contains(array $keys);

    /**
     * Verifies if any of the keys
     * in an array is missing in
     * the container. Returns
     * first key missing
     *
     * @param  array  $keys
     *
     * @return string|boolean
     */
    public function missing(array $keys);

    /**
     * Returns the data array.
     *
     * @return array
     */
    public function all();
}
