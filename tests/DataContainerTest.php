<?php

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\DataContainer;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;

class DataContainerTest extends TestCase
{
    /** @test */
    public function make_can_be_used_to_instantiate_a_container()
    {
        $container = DataContainer::make();

        $this->assertInstanceOf(DataContainerInterface::class, $container);
    }

    /** @test */
    public function an_arbitrary_key_and_value_pair_can_be_set()
    {
        $container = new DataContainer();
        $container->newKey = 'New content';
        $this->assertEquals('New content', $container->newKey);
    }

    /** @test */
    public function a_container_can_be_fill_after_it_has_been_instantiated()
    {
        $container = new DataContainer();
        $container->fill([
            'key' => 'value'
        ]);

        $this->assertEquals('value', $container->key);
    }

    /** @test */
    public function a_value_can_be_pushed_to_a_collection()
    {
        $container = new DataContainer();
        $container->push('value');

        $this->assertCount(1, $container);
        $this->assertEquals('value', $container[0]);
    }

    /** @test */
    public function values_can_be_added_to_the_container_after_it_has_been_instantiated()
    {
        $container = new DataContainer([
            'key' => 'value'
        ]);
        $container->add([
            'another' => 'day'
        ]);

        $this->assertCount(2, $container);
        $this->assertEquals('day', $container->another);
    }

    /** @test */
    public function if_a_non_existing_value_is_accessed_a_php_notice_is_triggered()
    {
        $container = new DataContainer();
        $this->expectException(Notice::class);
        $container->nope;
    }

    /** @test */
    public function isset_can_be_used_to_verify_if_value_exists()
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
    public function the_missing_method_can_be_used_to_verify_if_multiple_keys_have_not_been_set()
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

        $content = $container->all();

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
    }

    /** @test */
    public function all_values_can_also_be_access_using_the_to_array_method()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $content = $container->toArray();

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
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
    public function a_data_container_can_also_be_treated_as_an_array()
    {
        $container = new DataContainer();
        $container['dollars'] = '$10.00';
        $container['new'] = 'look';
        $container['hobbies'] = ['run', 'play pokemon go', 'drink wine'];
        $container[] = 'Yo';

        $this->assertEquals('$10.00', $container['dollars']);
        $this->assertEquals('look', $container['new']);
        $this->assertEquals(['run', 'play pokemon go', 'drink wine'], $container['hobbies']);
        $this->assertEquals('Yo', $container[0]);
        $this->assertTrue(isset($container['dollars']));

        unset($container['dollars']);

        $this->assertFalse(isset($container['dollars']));

    }
    
    /** @test */
    public function if_a_non_existing_value_is_accessed_as_an_array_a_php_notice_is_triggered()
    {
        $container = new DataContainer();
        
        $this->expectException(Notice::class);

        $container['nope'];
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
