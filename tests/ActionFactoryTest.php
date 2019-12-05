<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\ActionFactory;
use hatagency\CrudAssistant\Actions\LaravelValidationRules;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
    public function an_action_can_be_registered_after_the_factory_has_been_instantiated()
    {
        $factory = new ActionFactory([
            Chatagency\CrudAssistant\Actions\Database::class,
            Chatagency\CrudAssistant\Actions\Migration::class,
            Chatagency\CrudAssistant\Actions\Sanitation::class,
        ]);

        $this->assertFalse($factory->issetAction(LaravelValidationRules::class));
        $factory->registerAction(LaravelValidationRules::class);
        $this->assertTrue($factory->issetAction(LaravelValidationRules::class));
    }

    /** @test */
    public function an_exception_is_thrown_if_the_action_does_not_exist_when_get_action_is_called()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = $this->getConfig();
        $factory = new ActionFactory($config);
        $factory->getAction('unknow');
    }
}
