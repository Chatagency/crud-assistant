<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Countable;
use ArrayAccess;
use IteratorAggregate;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Concerns\isDataContainer;

/**
 * DataContainer.
 */
final class DataContainer implements DataContainerInterface, IteratorAggregate, Countable, ArrayAccess
{
    use isDataContainer;
}
