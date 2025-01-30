<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Modifiers;

use Chatagency\CrudAssistant\Contracts\ModifierInterface;


class BooleanModifier implements ModifierInterface
{

    public function __construct(
        private string $trueLabel = 'Yes',
        private string $falseLabel = 'No'
    )
    {}

    public function modify($value,  $model = null)
    {
        return $value ? $this->trueLabel : $this->falseLabel;
    }
}
