<?php

namespace Contracts;

use Chatagency\CrudAssistant\DataContainer;

interface ModifierInterface
{
    public function modify($value, $model = null);
}
