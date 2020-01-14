<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use InvalidArgumentException;

/**
 * Action base class.
 */
class Action
{
    /**
     * Checks params integrity.
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    protected function checkRequiredParams(DataContainer $data, array $checks)
    {
        foreach ($checks as $check) {
            if (!isset($data->$check)) {
                throw new InvalidArgumentException('The argument '.$check.' is missing from the DataContainer class');
            }
        }

        return true;
    }
}
