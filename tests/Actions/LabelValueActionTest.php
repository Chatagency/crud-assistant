<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Input;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
use Chatagency\CrudAssistant\Recipes\LabelValueRecipe;
use PHPUnit\Framework\TestCase;

class LabelValueActionTest extends TestCase
{
    public function testMakeCanBeUsedToGetAnInstanceOfLabelAction()
    {
        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $recipe = LabelValueAction::make($model);

        $this->assertInstanceOf(LabelValueAction::class, $recipe);
    }

    public function testTheLabelValueActionReturnsAnContainerWithLabelsAsKeys()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $action = new LabelValueAction($model);

        $action->prepare();
        foreach ($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $emailName = $email->getName();
        $emailLabel = $email->getLabel();

        $this->assertCount(2, $output);
        $this->assertEquals($model->$emailName, $output->$emailLabel);
    }

    public function testAnInternalCollectionCanBeUsedOnTheLabelActionForOrganizationPurposes()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $nickname = new TextInput('nickname', 'Nickname');
        $hobby = new TextInput('hobby', 'Hobby');

        $extraInfo = new InputCollection('extra_info');
        $extraInfo->setInputs([
            $nickname,
            $hobby,
        ]);

        $inputs = [$name, $email, $extraInfo];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
            'nickname' => 'Joe',
            'hobby' => 'To Read',
        ]);

        $crud = CrudAssistant::make($inputs);
        $output = $crud->execute(
            LabelValueAction::make($model)
        );

        $this->assertCount(4, $output);
    }

    public function testAClosureCanBeUsedToAlterTheLabelOnTheLabelValueAction()
    {
        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');

        $nameFormat = 'The %s is';

        $nameRecipe = new LabelValueRecipe(function (Input $input, DataContainer $params) use ($nameFormat) {
            return \sprintf($nameFormat, $input->getLabel());
        });

        $name->setRecipe($nameRecipe);

        $emailFormat = 'The address is %s';

        $emailRecipe = new LabelValueRecipe(null, function (Input $input, $model) use ($emailFormat) {
            return \sprintf($emailFormat, $model->email);
        });

        $email->setRecipe($emailRecipe);

        $inputs = [$name, $email];

        $model = new DataContainer([
            'name' => 'John Doe',
            'email' => 'john@email.com',
        ]);

        $action = new LabelValueAction($model);
        $action->prepare();

        foreach ($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $nameLabel = \sprintf($nameFormat, $name->getLabel());
        $emailLabel = $email->getLabel();

        $this->assertCount(2, $output);
        $this->assertEquals($output->$nameLabel, $model->name);
        $this->assertNotEquals($output->$emailLabel, $model->email);
    }

    public function testModifiersCanBeAddedToTheLabelValueActionRecipe()
    {
        $name = new TextInput('name', 'Name');
        $accept = new TextInput('accept', 'Accept Terms');

        $trueLabel = 'I Accept';

        $recipe = new LabelValueRecipe();
        $recipe->setModifiers([
            new BooleanModifier($trueLabel),
        ]);
        $accept->setRecipe($recipe);

        $inputs = [$name, $accept];

        $model = new DataContainer([
            'name' => 'John Doe',
            'accept' => true,
        ]);

        $action = new LabelValueAction($model);

        $action->prepare();
        foreach ($inputs as $input) {
            $action->execute($input);
        }
        $output = $action->getOutput();

        $this->assertEquals($trueLabel, $output->{$accept->getLabel()});
    }
}
