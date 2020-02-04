<?php

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\DataContainer;

/**
 * Modifer Base Class
 */
abstract class Modifier
{
    abstract public function modify($value, DataContainer $data = null);
}
