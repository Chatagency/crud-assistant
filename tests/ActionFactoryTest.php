<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
use hatagency\CrudAssistant\Actions\LaravelValidation;
use InvalidArgumentException;

class ActionFactoryTest extends TestCase
{
    public function getConfig()
    {
        /**
         * Laravel config() is not available
         * inside the package
         * @var array
         */
        return require __DIR__.'/../config/config.php';
        
    }
    
    /** @test */
    public function the_factory_can_be_creted_with_an_array_of_actions()
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
        
        $this->assertFalse($factory->issetAction(LaravelValidation::class));
        $factory->registerAction(LaravelValidation::class);
        $this->assertTrue($factory->issetAction(LaravelValidation::class));
        
    }
    
    /** @test */
    public function an_exeption_is_thrown_if_the_action_has_not_been_registed_or_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $config = $this->getConfig();
        $factory = new ActionFactory($config);
        $factory->getAction('unknow');
    }
    
}
