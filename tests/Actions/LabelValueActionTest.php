<?php

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LabelValueActionTest extends TestCase
{
    /** @test */
    public function the_label_value_action_returns_an_array_with_labels_as_keys()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $labelValues = (new LabelValueAction())->execute($inputs, new DataContainer([
            'model' => $model,
        ]));

        $emailName = $email->getName();

        $this->assertCount(2, $labelValues);
        $this->assertEquals($model->$emailName, $labelValues[$email->getLabel()]);

    }

    /** @test */
    public function if_the_model_is_not_specified_an_exception_is_throw()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $this->expectException(InvalidArgumentException::class);

        (new LabelValueAction())->execute($inputs, new DataContainer([]));
    }

    /** @test */
    public function an_input_can_be_ignored_by_the_label_value_action()
    {
        $name = new TextInput('name', 'Name');
        $name->setRecipe(LabelValueAction::class, [
            'ignore' => true
        ]);
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $labelValues = (new LabelValueAction())->execute($inputs, new DataContainer([
            'model' => $model,
        ]));

        $this->assertCount(1, $labelValues);
        $this->assertNotContains($model->name, $labelValues);

    }

    /** @test */
    public function modifiers_can_be_added_to_the_label_value_action_recipe()
    {
        $name = new TextInput('name', 'Name');
        $accept = new TextInput('accept', 'Accept Terms');

        $modifierData = new DataContainer([
            'trueLabel' => 'I Accept'
        ]);

        $accept->setRecipe(LabelValueAction::class, [
            'modifiers' => [
                new BooleanModifier($modifierData)
            ]
        ]);

        $inputs = [$name, $accept];

        $model = new DataContainer([
            'name' => 'John Doe',
            'accept' => true,
        ]);

        $labelValues = (new LabelValueAction())->execute($inputs, new DataContainer([
            'model' => $model,
        ]));

        $this->assertEquals($modifierData->trueLabel, $labelValues['Accept Terms']);

    }
}