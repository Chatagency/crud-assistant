<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Concerns\IsDataContainer;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer.
 */
#[\AllowDynamicProperties]
final class DataContainer implements DataContainerInterface, \IteratorAggregate, \Countable, \ArrayAccess
{
    use IsDataContainer;

    public static function make(array $data = []): DataContainerInterface
    {
        return new static($data);
    }
}
