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
     * @param DataContainer $data
     *
     * @param array $checks
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    protected function paramsExist(DataContainer $data, array $checks)
    {
        foreach ($checks as $check) {
            if (!isset($data->$check)) {
                throw new InvalidArgumentException("The argument ". $check . " is missing from the DataContainer class" );
            }
        }
        
        return true;
    }
}
