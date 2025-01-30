<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests\Actions;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\FilterRecipe;
use PHPUnit\Framework\TestCase;

class FilterActionTest extends TestCase
{
    public function testMakeCanBeUsedToGetAnInstanceOfFilterAction()
    {
        $recipe = FilterAction::make();

        $this->assertInstanceOf(FilterAction::class, $recipe);
    }

    public function testAFilterActionIsUsedToExcludeInputDataFromDataset()
    {
        $filter = new FilterAction();

        $name = new TextInput('name', 'Name');

        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->filter = true;

        $email->setRecipe($recipe);

        $description = new TextInput('description', 'Description');

        $crud = CrudAssistant::make([$email, $name, $description]);

        $filter = new FilterAction([
            'name' => 'Victor Sánchez',
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        $filtered = $crud->execute($filter);

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));
    }

    public function testAnInternalInputCollectionCanBeUsedOnTheFilterActionForOrganizationPurposes()
    {
        $filter = new FilterAction();

        $name = new TextInput('name', 'Name');
        $email = new TextInput('email', 'Email');
        $description = new TextInput('description', 'Description');

        $emailRecipe = new FilterRecipe();
        $emailRecipe->filter = true;
        $email->setRecipe($emailRecipe);

        $nickname = new TextInput('nickname', 'Nickname');
        $hobby = new TextInput('hobby', 'Hobby');

        $nickRecipe = FilterRecipe::make();
        $nickRecipe->filter = true;
        $nickname->setRecipe($nickRecipe);

        $extraInfo = new InputCollection('extra_info');
        $extraInfo->setInputs([
            $nickname,
            $hobby,
        ]);

        $crud = CrudAssistant::make([$email, $name, $description, $extraInfo]);

        $filter = new FilterAction([
            'name' => 'Victor Sánchez',
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit',
            'nickname' => 'Vic',
            'hobby' => 'To code',
        ]);

        $filtered = $crud->execute($filter);

        $this->assertCount(3, $filtered->data);
    }

    public function testAClosureCanBePassedAsAValueInsteadOfAnArrayToTheFilterAction()
    {
        $name = new TextInput('name', 'Name');

        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->callback = function ($input, $data) {
            unset($data[$input->getName()]);

            return $data;
        };

        $email->setRecipe($recipe);

        $description = new TextInput('description', 'Description');

        $inputs = [$name, $email, $description];

        $filter = new FilterAction([
            'name' => 'Victor Sánchez',
            'email' => 'email@email.com',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        $filter->prepare();
        foreach ($inputs as $input) {
            $filter->executeOne($input);
        }
        $filtered = $filter->getOutput();

        $this->assertCount(2, $filtered->data);
        $this->assertFalse(isset($filtered->data[$email->getName()]));
    }

    public function testIfIgnoreIfEmptyIsPassedToTheFilterActionThatItemIsAlsoFiltered()
    {
        $name = new TextInput('name', 'Name');

        $email = new TextInput('email', 'Email');

        $recipe = new FilterRecipe();
        $recipe->ignoreIfEmpty = true;

        $email->setRecipe($recipe);

        $description = new TextInput('description', 'Description');

        $inputs = [$name, $email, $description];

        $filter = new FilterAction([
            'name' => 'Victor Sánchez',
            'email' => '',
            'description' => 'Lorem ipsum dolor sit',
        ]);

        $filter->prepare();
        foreach ($inputs as $input) {
            $filter->executeOne($input);
        }
        $filtered = $filter->getOutput();

        $this->assertCount(2, $filtered->data);
    }

    public function testIfAnInvalidValueIsPassedToTheRecipeAnExceptionIsThrown()
    {
        $this->expectException(\Exception::class);

        $recipe = new FilterRecipe();
        $recipe->NotValid = true;
    }
}
