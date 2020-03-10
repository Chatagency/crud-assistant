<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

/**
 * Modifer Base Class.
 */
abstract class Modifier
{
    abstract public function modify($value, DataContainer $data = null);
}
