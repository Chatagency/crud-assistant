<?php

namespace Chatagency\CrudAssistant\Tests;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\DataContainer;
use PHPUnit\Framework\Error\Notice;

class DataContainerTest extends TestCase
{
    /** @test */
    public function both_key_and_value_have_public_access()
    {
        $container = new DataContainer('key1', 'This is the value 1');
        $this->assertEquals('key1', $container->key);
        $this->assertEquals('This is the value 1', $container->value);
    }
    
    /** @test */
    public function both_key_and_value_can_be_set_after_the_container_has_been_instantiated()
    {
        $container = new DataContainer();
        $container->key = 'key2';
        $container->value = 'This is the value 2';
        $this->assertEquals('key2', $container->key);
        $this->assertEquals('This is the value 2', $container->value);
    }
    
    /** @test */
    public function an_arbitrary_key_and_value_pair_can_be_set()
    {
        $container = new DataContainer();
        $container->newkey = 'New content';
        $this->assertEquals('New content', $container->newkey);
    }
    
    /** @test */
    public function if_a_non_existing_value_is_accessed_a_php_notice_is_triggered()
    {
        $container = new DataContainer();
        $this->expectException(Notice::class);
        $container->nope;
    }
    
    /** @test */
    public function isset_can_be_used_to_verifiy_if_value_exists()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        
        $this->assertTrue(isset($container->dollars));
        $this->assertFalse(isset($container->euros));
    }
    
    /** @test */
    public function unset_can_be_used_to_delete_values()
    {
        $container = new DataContainer();
        $container->new = 'look';
        
        $this->assertEquals('look', $container->new);
        unset($container->new);
        $this->assertFalse(isset($container->new));
        
    }
    
    /** @test */
    public function all_values_can_be_access_using_the_all_method()
    {
        $container = new DataContainer('key1', 'This is the value 1');
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];
        
        $this->assertCount(5, $container->all());
        
    }
    
}