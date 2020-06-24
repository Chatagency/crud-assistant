<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use InvalidArgumentException;

class ActionFactoryTest extends TestCase
{
    /** @test */
    public function an_exception_is_thrown_if_the_action_does_not_exist_when_get_action_is_called()
    {
        $this->expectException(InvalidArgumentException::class);
        $factory = new ActionFactory();
        $factory->getAction('unknown');
    }
    
    /** @test */
    public function an_exception_is_thrown_if_the_action_exists_in_the_the_factory_but_the_class_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $config[] = 'This\Class\Does\Not\Exist';
        $factory = new ActionFactory();
        $yo = $factory->getAction('This\Class\Does\Not\Exist');
        
    }

    /** @test */
    public function an_exception_is_thrown_if_the_action_exists_in_the_the_factory_but_does_not_extend_the_action_interface()
    {
        $this->expectException(InvalidArgumentException::class);
        $config[] = FakeAction::class;
        $factory = new ActionFactory();
        $yo = $factory->getAction(FakeAction::class);
        
    }
}
