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
        if($missing = $data->missing($checks)){
            throw new InvalidArgumentException('The argument '.$missing.' is missing from the DataContainer class', 500);
        }
        
        return true;
    }
}
