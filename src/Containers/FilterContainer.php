<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Containers;

use Chatagency\CrudAssistant\Concerns\IsDataContainer;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

final class FilterContainer implements \ArrayAccess, \Countable, DataContainerInterface, \IteratorAggregate
{
    use IsDataContainer;

    public static function make(array $data = []): DataContainerInterface
    {
        return new static($data);
    }
}
