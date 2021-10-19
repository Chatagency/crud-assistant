<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use Chatagency\CrudAssistant\DataContainer;

class BooleanModifierTest extends TestCase
{
    /** @test */
    public function the_is_boolean_modifier_changes_the_label_of_a_boolean_value()
    {
        $modifier = new BooleanModifier();
        
        $newTrueValue = $modifier->modify(true);
        $this->assertEquals('Yes', $newTrueValue);
        
        $newFalseValue = $modifier->modify(false);
        $this->assertEquals('No', $newFalseValue);
    }
    
    /** @test */
    public function the_is_boolean_modifier_labels_can_be_changed_using_the_second_argument()
    {
        $data = new DataContainer([
            'trueLabel' => 'Correct',
            'falseLabel' => 'Incorrect',
        ]);
        
        $modifier = new BooleanModifier($data);
        
        $newTrueValue = $modifier->modify(true);
        $this->assertEquals($data->trueLabel, $newTrueValue);
        
        $newFalseValue = $modifier->modify(false);
        $this->assertEquals($data->falseLabel, $newFalseValue);
    }
    
}
