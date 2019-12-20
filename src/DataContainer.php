<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer.
 */
class DataContainer implements DataContainerInterface
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
        if (!isset($this->data[$name])) {
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
     * Returns the data array.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }
}
