<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Contracts\DataContainerInterface;
use Chatagency\CrudAssistant\DataContainer;
use PHPUnit\Framework\TestCase;

class DataContainerTest extends TestCase
{
    public function testMakeCanBeUsedToInstantiateAContainer()
    {
        $container = DataContainer::make();

        $this->assertInstanceOf(DataContainerInterface::class, $container);
    }

    public function testAnArbitraryKeyAndValuePairCanBeSet()
    {
        $container = new DataContainer();
        $container->newKey = 'New content';
        $this->assertEquals('New content', $container->newKey);
    }

    public function testAContainerCanBeFillAfterItHasBeenInstantiated()
    {
        $container = new DataContainer();
        $container->fill([
            'key' => 'value',
        ]);

        $this->assertEquals('value', $container->key);
    }

    public function testAValueCanBePushedToACollection()
    {
        $container = new DataContainer();
        $container->push('value');

        $this->assertCount(1, $container);
        $this->assertEquals('value', $container[0]);
    }

    public function testValuesCanBeAddedToTheContainerAfterItHasBeenInstantiated()
    {
        $container = new DataContainer([
            'key' => 'value',
        ]);
        $container->add([
            'another' => 'day',
        ]);

        $this->assertCount(2, $container);
        $this->assertEquals('day', $container->another);
    }

    public function testIfANonExistingValueIsAccessedAPhpNoticeIsTriggered()
    {
        $this->expectException(\InvalidArgumentException::class);

        $container = new DataContainer();

        $container->nope;
    }

    public function testIssetCanBeUsedToVerifyIfValueExists()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';

        $this->assertTrue(isset($container->dollars));
        $this->assertFalse(isset($container->euros));
    }

    public function testUnsetCanBeUsedToDeleteValues()
    {
        $container = new DataContainer();
        $container->new = 'look';

        $this->assertEquals('look', $container->new);
        unset($container->new);
        $this->assertFalse(isset($container->new));
    }

    public function testTheContainsMethodCanBeUsedToVerifyIfMultipleKeysHaveBeenSet()
    {
        $values = ['new' => 'look', 'old' => 'story'];
        $container = new DataContainer($values);

        $this->assertTrue($container->contains(array_keys($values)));
        unset($container->new);
        $this->assertFalse($container->contains(array_keys($values)));
    }

    public function testTheMissingMethodCanBeUsedToVerifyIfMultipleKeysHaveNotBeenSet()
    {
        $values = ['new' => 'look', 'old' => 'story'];
        $container = new DataContainer($values);

        $this->assertFalse($container->missing(array_keys($values)));
        unset($container->new);
        $this->assertEquals('new', $container->missing(array_keys($values)));
    }

    public function testAllValuesCanBeAccessUsingTheAllMethod()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $content = $container->all();

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
    }

    public function testAllValuesCanAlsoBeAccessUsingTheToArrayMethod()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $content = $container->toArray();

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
    }

    public function testCountCanBeUsedOnADataContainerObject()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $this->assertCount(3, $container);
    }

    public function testADataContainerCanAlsoBeTreatedAsAnArray()
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

    public function testIfANonExistingValueIsAccessedAsAnArrayAPhpNoticeIsTriggered()
    {
        $this->expectException(\InvalidArgumentException::class);

        $container = new DataContainer();

        $container['nope'];
    }

    public function testADataContainerObjectCanBeIteratedOver()
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

    public function testADataContainerOutputsJsonWhenEchoed()
    {
        $container = new DataContainer();
        $container->dollars = '$10.00';
        $container->new = 'look';
        $container->hobbies = ['run', 'play pokemon go', 'drink wine'];

        $this->assertStringContainsString('$10.00', $container->__toString());
    }
}
