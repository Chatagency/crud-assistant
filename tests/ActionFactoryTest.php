<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\CrudAssistant;
use InvalidArgumentException;

class ActionFactoryTest extends TestCase
{
    
    /** @test */
    public function the_action_factory_can_instantiate_an_action_using_the_name()
    {
        $factory = new ActionFactory();
        $action = $factory->getInstance(FilterAction::class);
        
        $this->assertInstanceOf(FilterAction::class, $action);
    }

    /** @test */
    public function if_the_instantiated_action_does_not_exist_or_is_invalid_an_exception_is_throw()
    {
        $this->expectException(InvalidArgumentException::class);
        
        $factory = new ActionFactory();
        $action = $factory->getInstance(CrudAssistant::class);
    }

    /** @test */
    public function the_action_factory_can_check_if_a_class_is_a_real_action()
    {
        $factory = new ActionFactory();
        $action = $factory->isAction(FilterAction::class);
        
        $this->assertEquals($action, FilterAction::class);
    }
    
    /** @test */
    public function the_get_action_returns_false_if_the_action_does_not_exist()
    {
        $factory = new ActionFactory();
        $this->assertFalse($factory->isAction('This\Class\Does\Not\Exist'));
        
    }

    /** @test */
    public function the_get_action_returns_false_if_the_action_does_not_extend_the_action_interface()
    {
        $factory = new ActionFactory();
        $this->assertFalse( $factory->isAction(CrudAssistant::class));
        
    }
    
}
