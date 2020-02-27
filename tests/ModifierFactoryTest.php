<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ModifierFactory;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;

/**
 * Form Test
 */
class ModifierFactoryTest extends TestCase
{
    /** @test */
    public function the_modifier_factory_instaciate_the_correct_modifier_class()
    {
        $modifer = ModifierFactory::make(BooleanModifier::class);
        
        $this->assertInstanceOf(BooleanModifier::class, $modifer);
    }
    
    /** @test */
    public function the_name_of_the_class_and_also_be_passed_to_the_modifier_factory()
    {
        $modifer = ModifierFactory::make('BooleanModifier');
        
        $this->assertInstanceOf(BooleanModifier::class, $modifer);
    }
    
    /** @test */
    public function if_the_class_passed_to_the_modifier_factory_does_exist_an_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        $modifer = ModifierFactory::make('\This\Class\Does\Not\Exist');
    }
    
    
    /** @test */
    public function if_the_class_passed_to_the_modifier_factory_exisits_but_is_not_a_modifier_an_exception_is_thrown()
    {
        $this->expectException(\Exception::class);
        $modifer = ModifierFactory::make(\Chatagency\CrudAssistant\DataContainer::class);
    }
}