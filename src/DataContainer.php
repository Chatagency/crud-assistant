<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Concerns\isDataContainer;
use Chatagency\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer.
 */
final class DataContainer implements DataContainerInterface, \IteratorAggregate, \Countable, \ArrayAccess
{
    use isDataContainer;
}
