<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Actions\PrepareCleanupAction;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\LabelValueRecipe;
use PHPUnit\Framework\TestCase;

class InputCollectionTest extends TestCase
{
    public function testACollectionCanHaveMultipleInputs()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals($form->count(), 1);

        $form->addInput(new TextInput('email', 'Email'));
        $this->assertEquals($form->count(), 2);
    }

    public function testInputsCanBeAccessedUsingGetInput()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $name = $form->getInput('name');
        $this->assertEquals('name', $name->getName());
        $this->assertCount(1, $form->getInputs());
    }

    public function testIssetCanBeUsedToCheckIfAnInputExists()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $form->addInput(new TextInput('email', 'Email'));

        $this->assertTrue($form->isset('name'));
        $this->assertFalse($form->isset('does_no_exist'));
    }

    public function testAnExceptionIsThrownIfANonExistingInputIsAccessed()
    {
        $this->expectException(\InvalidArgumentException::class);
        $form = new InputCollection();
        $form->getInput('name');
    }

    public function testAnInputCanBeRemovedFromTheCollection()
    {
        $form = new InputCollection();

        $form->addInput(new TextInput('name', 'Name'));
        $this->assertEquals(1, $form->count());

        $form->removeInput('name');
        $this->assertEquals(0, $form->count());
    }

    public function testAnActionCanBeExecutedFromACollection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection();
        $form->setInputs([$name, $email]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
        ]);

        $labelValue = $form->execute(
            LabelValueAction::make($model)
        );

        $this->assertCount(2, $labelValue);
    }

    public function testIfIgnoreIsSetOnTheRecipeOfAnInputThatInputWillNotBeSentToTheAction()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $email->setRecipe(
            LabelValueRecipe::make()
                ->ignore()
        );

        $form = new InputCollection();
        $form->setInputs([$name, $email]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
        ]);

        $labelValue = $form->execute(
            LabelValueAction::make($model)
        );

        $this->assertCount(1, $labelValue);
    }

    public function testACollectionCanReturnAnArrayOfTheInputNames()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection();
        $form->setInputs([$name, $email]);
        $names = $form->getInputNames();

        $this->assertCount(2, $names);
        $this->assertContains($name->getName(), $names);
        $this->assertContains($email->getName(), $names);
    }

    public function testACollectionCanReturnAnArrayOfTheInputLabels()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $form = new InputCollection();
        $form->setInputs([$name, $email]);
        $labels = $form->getInputLabels();

        $this->assertCount(2, $labels);
        $this->assertContains($name->getLabel(), $labels);
        $this->assertContains($email->getLabel(), $labels);
    }

    public function testAPartialInputCollectionCanBeCreated()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $this->assertCount(3, $form->getInputNames());

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(2, $form->getInputNames());
    }

    public function testASubCollectionCanBeAccessedUsingGetPartialCollection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(2, $form->getPartialCollection());
    }

    public function testIfAnEmptyArrayIsPassedWhenCreatingASubCollectionAnExceptionIsThrown()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $this->assertCount(3, $form->getInputNames());

        $this->expectException(\Exception::class);

        $form->setPartialCollection([]);
    }

    public function testIfNoInputsHaveBeenSetAnExceptionIsThrownWhenTryingCreateAnSubCollection()
    {
        $form = new InputCollection();

        $this->expectException(\Exception::class);

        $form->setPartialCollection(['name']);
    }

    public function testIfAnInputIsRemovedFromTheCollectionItIsAlsoRemovedFromTheSubCollection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        $form->setPartialCollection(['name', 'email']);

        $this->assertCount(3, $form->getInputs(true));
        $this->assertCount(2, $form->getInputs());

        $form->removeInput('name');

        $this->assertCount(2, $form->getInputs(true));
        $this->assertCount(1, $form->getInputs());
    }

    public function testTheInputCollectionIsIterable()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address]);

        foreach ($form as $input) {
            $this->assertInstanceOf(InputInterface::class, $input);
        }
    }

    public function testAnInputCollectionCanContainOtherInputCollection()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');

        $collection = new InputCollection('secondary_info');
        $collection->setInputs([
            new TextInput('age', 'Your age'),
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $address, $collection]);

        $this->assertCount(4, $form);
        $this->assertInstanceOf(InputCollection::class, $form->getInput('secondary_info'));
    }

    public function testIfProcessInternalCollectionIsTrueTheInternalCollectionIsProcessedLikeANormalInput()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $address = new TextInput('address', 'address');
        $age = new TextInput('age', 'Your age');

        $collection = new InputCollection('collection_value');
        $collection->setInputs([
            $address,
            $age,
        ]);

        $form = new InputCollection();
        $form->setInputs([$name, $email, $collection]);

        $model = new DataContainer([
            'name' => 'John',
            'email' => 'john#@email.com',
            'address' => '123 6 street',
            'age' => 26,
            'collection_value' => 'This is your collection value',
        ]);

        $output = $form->execute(
            LabelValueAction::make($model)
        );

        $this->assertCount(4, $output);

        $output2 = $form->execute(
            LabelValueAction::make($model)
                ->setProcessInternalCollection(true)
        );

        $this->assertCount(5, $output2);
    }

    public function testThePrepareAndCleanupExecutionCanBeDisabled()
    {
        $collection = new InputCollection('collection_1');
        $collection
            ->setInputs([
                new TextInput('name', 'Name'),
            ]);

        $output = $collection->execute(
            new PrepareCleanupAction()
        );

        $this->assertCount(3, $output);

        $collection2 = new InputCollection('collection_1');
        $collection2
            ->setInputs([
                new TextInput('name', 'Name'),
            ])
            ->disablePrepare()
            ->disableCleanup();

        $output2 = $collection2->execute(
            new PrepareCleanupAction()
        );

        $this->assertCount(1, $output2);
    }
}
