<?php

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Data DataContainer Interface.
 */
interface DataContainerInterface
{
    /**
     * Construct can receive a data array.
     */
    public function __construct(array $data = []);

    /**
     * Returns the data array.
     *
     * @return array
     */
    public function all();

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
     */
    public function __unset(string $name);
}
