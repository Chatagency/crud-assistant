<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class CrudAssistantTest extends TestCase
{
    public function testWhenTheMakeMethodIsCalledOnCrudAssistantAnInputCollectionInstanceIsReturned()
    {
        $manager = CrudAssistant::make([]);

        $this->assertInstanceOf(InputCollectionInterface::class, $manager);
    }

    public function testAnArrayOfInputsInstancesCanBePassedToTheConstructor()
    {
        $inputs = [
            new TextInput('name'),
            new TextInput('email'),
        ];

        $manager = new CrudAssistant($inputs);

        $this->assertEquals(2, $manager->getCollection()->count());
    }

    public function testTheIsInputCollectionHelperChecksIfParameterIsAnInputCollection()
    {
        $this->assertTrue(CrudAssistant::isInputCollection(new InputCollection()));

        $this->assertFalse(CrudAssistant::isInputCollection(new TextInput()));
    }

    public function testTheIsClosureHelperChecksIfParameterIsAClosure()
    {
        $this->assertTrue(CrudAssistant::isClosure(function () {}));

        $this->assertFalse(CrudAssistant::isClosure('array_map'));
    }
}
