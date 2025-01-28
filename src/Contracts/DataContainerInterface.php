<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Data DataContainer Interface.
 * 
 * @property array $data
 */
interface DataContainerInterface
{
    public function get(string $name);

    public function set(string $name, mixed $value): static;
    
    /**
     * Fills the container. It replaces
     * the current data array with
     * the one provided.
     *
     * @return self
     */
    public function fill(array $data);

    /**
     * Adds values to the data array.
     *
     * @return self
     */
    public function add(array $data);
    
    /**
     * Pushes a value to the data array.
     *
     * @param mixed $value
     * @return self
     */
    public function push($value);

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
    public function toArray();

    /**
     * toArray() method alias.
     *
     * @return array
     */
    public function all();

}
