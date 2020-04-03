<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use Chatagency\CrudAssistant\Actions\LaravelValidationRules;
use InvalidArgumentException;
use Chatagency\CrudAssistant\Tests\TestClasses\TesAction;
use Chatagency\CrudAssistant\Tests\TestClasses\TestActionTwo;
use Chatagency\CrudAssistant\Tests\TestClasses\FakeAction;

class ActionFactoryTest extends TestCase
{
    public function getConfig()
    {
        /*
         * Laravel config() is not available
         * inside the package
         * @var array
         */
        return require __DIR__.'/../config/config.php';
    }

    /** @test */
    public function the_factory_must_be_created_with_an_array_of_actions()
    {
        $config = $this->getConfig();
        $factory = new ActionFactory($config);

        $this->assertCount(count($config), $factory->getActions());
    }

    /** @test */
    public function the_action_factory_returns_an_instance_if_it_is_in_the_right_path_and_is_a_real_action()
    {
        $factory = new ActionFactory([]);

        $this->assertTrue($factory->issetAction(LaravelValidationRules::class));
        $this->assertInstanceOf(LaravelValidationRules::class, $factory->getInstanse(LaravelValidationRules::class));
    }

    
    /** @test */
    public function a_non_action_package_can_be_registered_either_in_the_constructor_or_after_instantiated()
    {
        $factory = new ActionFactory([
            TestAction::class
        ]);

        $this->assertTrue($factory->issetAction(TestAction::class));

        $this->assertFalse($factory->issetAction(TestActionTwo::class));
        $factory->registerAction(TestActionTwo::class);
        $this->assertTrue($factory->issetAction(TestActionTwo::class));
    }

    /** @test */
    public function an_exception_is_thrown_if_the_action_does_not_exist_when_get_action_is_called()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = $this->getConfig();
        $factory = new ActionFactory($config);
        $factory->getAction('unknow');
    }
    
    /** @test */
    public function an_exception_is_thrown_if_the_action_exists_in_the_the_factory_but_the_class_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = $this->getConfig();
        $config[] = 'This\Class\Does\Not\Exist';
        $factory = new ActionFactory($config);
        $yo = $factory->getAction('This\Class\Does\Not\Exist');
        
    }

    /** @test */
    public function an_exception_is_thrown_if_the_action_exists_in_the_the_factory_but_does_not_extend_the_action_interface()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = $this->getConfig();
        $config[] = FakeAction::class;
        $factory = new ActionFactory($config);
        $yo = $factory->getAction(FakeAction::class);
        
    }
}
