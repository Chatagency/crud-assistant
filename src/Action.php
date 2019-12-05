<?php

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
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function paramsExist(DataContainer $data, array $checks)
    {
        foreach ($checks as $check) {
            if (!isset($data->$check)) {
                throw new InvalidArgumentException('The argument '.$check.' is missing from the DataContainer class');
            }
        }

        return true;
    }
}
