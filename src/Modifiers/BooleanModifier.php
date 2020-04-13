<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifier;

/**
 * Boolean Modifier.
 */
class BooleanModifier extends Modifier
{
    /**
     * True Label.
     *
     * @var string
     */
    protected $trueLabel = 'Yes';

    /**
     * False Label.
     *
     * @var string
     */
    protected $falseLabel = 'No';

    /**
     * Modifies value.
     *
     * @param mixed         $value
     * @param DataContainer $data
     * @param $model
     */
    public function modify($value, DataContainer $data = null, $model = null)
    {
        $trueLabel = $data->trueLabel ?? $this->trueLabel;
        $falseLabel = $data->falseLabel ?? $this->falseLabel;

        return $value ? $trueLabel : $falseLabel;
    }
}
