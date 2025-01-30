<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use PHPUnit\Framework\TestCase;

class BooleanModifierTest extends TestCase
{
    public function testTheIsBooleanModifierChangesTheLabelOfABooleanValue()
    {
        $modifier = new BooleanModifier();

        $newTrueValue = $modifier->modify(true);
        $this->assertEquals('Yes', $newTrueValue);

        $newFalseValue = $modifier->modify(false);
        $this->assertEquals('No', $newFalseValue);
    }

    public function testTheIsBooleanModifierLabelsCanBeChangedUsingTheSecondArgument()
    {
        $data = new DataContainer([
            'trueLabel' => 'Correct',
            'falseLabel' => 'Incorrect',
        ]);

        $modifier = new BooleanModifier($data['trueLabel'], $data['falseLabel']);

        $newTrueValue = $modifier->modify(true);
        $this->assertEquals($data->trueLabel, $newTrueValue);

        $newFalseValue = $modifier->modify(false);
        $this->assertEquals($data->falseLabel, $newFalseValue);
    }
}
