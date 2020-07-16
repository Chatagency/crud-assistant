<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\DataContainer;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;

class DataContainerTest extends TestCase
{
    /** @test */
    public function an_arbitrary_key_and_value_pair_can_be_set()
    {
        $container = new DataContainer();
        $container->newKey = 'New content';
        $this->assertEquals('New content', $container->newKey);
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
    public function the_contains_method_can_be_used_to_verify_if_multiple_keys_have_been_set()
    {
        $values = ['new' => 'look', 'old' => 'story'];
        $container = new DataContainer($values);
        
        $this->assertTrue($container->contains(array_keys($values)));
        unset($container->new);
        $this->assertFalse($container->contains(array_keys($values)));
    }
    
    /** @test */
    public function the_missing_method_can_be_used_to_verfify_if_multiple_keys_have_not_been_set()
    {
        $values = ['new' => 'look', 'old' => 'story'];
        $container = new DataContainer($values);
        
        $this->assertFalse($container->missing(array_keys($values)));
        unset($container->new);
        $this->assertEquals('new', $container->missing(array_keys($values)));
        
    }

    /** @test */
    public function all_values_can_be_access_using_the_all_method()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $this->assertCount(3, $container->all());
    }
    
    /** @test */
    public function count_can_be_used_on_a_data_container_object()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];
        
        $this->assertCount(3, $container);
        
    }
    
    /** @test */
    public function a_data_container_object_can_be_iterated_over()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];
        
        $newArray = [];
        foreach ($container as $key => $value) {
            $newArray[$key] = $value;
        }
        
        $this->assertEquals($newArray, $container->all());
        
    }

    /** @test */
    public function a_data_container_outputs_json_when_echoed()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];
        
        $this->assertStringContainsString('$10.00', $container);

    }
}
