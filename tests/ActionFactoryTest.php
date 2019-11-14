<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\ActionFactory;
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
    public function the_factory_can_be_instantiated_with_an_array_of_actions()
    {
        $config = $this->getConfig();
        $factory = new ActionFactory($config);
        
        $this->assertCount(count($config), $factory->getActions());
    }
    
    /** @test */
    public function an_action_can_be_registered_after_the_factory_has_been_instantiated()
    {
        $factory = new ActionFactory([
            "database" => Chatagency\CrudAssistant\Actions\Database::class,
            "migration" => Chatagency\CrudAssistant\Actions\Migration::class,
            "sanitaion" => Chatagency\CrudAssistant\Actions\Sanitation::class,
        ]);
        
        $this->assertFalse($factory->issetAction('validation'));
        $factory->registerAction('validation', Chatagency\CrudAssistant\Actions\Validation::class);
        $this->assertTrue($factory->issetAction('validation'));
        
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
