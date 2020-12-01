<?php

namespace Chatagency\CrudAssistant\Tests\Recipes;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\GenericRecipe;
use Exception;
use PHPUnit\Framework\TestCase;

class GenericRecipeTest extends TestCase
{
    /** @test */
    public function a_generic_recipe_can_can_be_passed_to_actions()
    {
        $name = new TextInput('name');
        $email = (new TextInput('email'))->setType('email');

        $genericRecipe = new GenericRecipe();
        $genericRecipe->setIdentifier(FilterAction::class);
        $genericRecipe->filter = true;

        $name->setRecipe($genericRecipe);

        $collection = (CrudAssistant::make([$name, $email]))->getCollection();

        $output = $collection->execute(new FilterAction(
            new DataContainer([
                'data' => [
                    'name' => 'John',
                    'email' => 'john@john.com'
                ]
            ])
        ));

        $data = $output->data;

        $this->assertCount(1, $data);
        $this->assertArrayNotHasKey('name', $data);
        
    }

    /** @test */
    public function setters_can_be_used_with_the_generic_recipe_to_make_setters_more_strict()
    {
        $name = new TextInput('name');
        $email = (new TextInput('email'))->setType('email');

        $genericRecipe = new GenericRecipe();
        $genericRecipe->setIdentifier(FilterAction::class);
        $genericRecipe->setSetters(['filter']);
        $genericRecipe->filter = true;

        $this->expectException(Exception::class);

        /**
         * If setter not available
         */
        $genericRecipe->notASetter = true;



    }
}
