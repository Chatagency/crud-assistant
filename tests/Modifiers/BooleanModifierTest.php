<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

// use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use Chatagency\CrudAssistant\DataContainer;

class BooleanModifierTest extends TestCase
{
    /** @test */
    public function the_is_boolean_modifier_changes_the_label_of_a_boolean_value()
    {
        $modifer = new BooleanModifier();
        
        $newTrueValue = $modifer->modify(true, new DataContainer([]));
        $this->assertEquals('Yes', $newTrueValue);
        
        $newFalseValue = $modifer->modify(false, new DataContainer([]));
        $this->assertEquals('No', $newFalseValue);
    }
    
    /** @test */
    public function the_is_boolean_modifier_labels_can_be_changed_using_the_second_argument()
    {
        $modifer = new BooleanModifier();
        
        $data = new DataContainer([
            'trueLabel' => 'Corrent',
            'falseLabel' => 'Incorrent',
        ]);
        
        $newTrueValue = $modifer->modify(true, $data);
        $this->assertEquals($data->trueLabel, $newTrueValue);
        
        $newFalseValue = $modifer->modify(false, $data);
        $this->assertEquals($data->falseLabel, $newFalseValue);
    }
    
}
