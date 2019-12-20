<?php

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Data DataContainer Interface.
 */
interface DataContainerInterface
{
    /**
     * Construct can receive a data array.
     *
     * @param array $data
     *
     * @return self
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
     *
     * @param string $name
     *
     */
    public function __get(string $name);

    /**
     * Magic set method.
     *
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value);

    /**
     * Magic isset method.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name);

    /**
     * Magic unset method.
     *
     * @param string $name
     *
     * @return null
     *
     */
    public function __unset(string $name);
}
