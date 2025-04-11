<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Concerns;

trait IsDataContainer
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function __get(string $name): mixed
    {
        if (!\array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$name];
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function __toString()
    {
        return json_encode($this->data);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function get(string $name)
    {
        if (!isset($this->data[$name])) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$name];
    }

    public function set(string $name, mixed $value): static
    {
        $this->data[$name] = $value;

        return $this;
    }

    public function fill(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function add(array $data): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function push($value): static
    {
        $this->data[] = $value;

        return $this;
    }

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
     * first key.
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

    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * toArray() method alias.
     */
    public function all(): array
    {
        return $this->toArray();
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
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
            throw new \InvalidArgumentException();
        }

        return $this->data[$offset];
    }
}
