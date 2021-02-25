<?php

namespace Chatagency\CrudAssistant\Tests\Recipes;

use Chatagency\CrudAssistant\Actions\FilterAction;
use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\CrudAssistant;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Modifiers\BooleanModifier;
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

        $collection = (CrudAssistant::make([$name, $email]));

        $params = new DataContainer([
            'data' => [
                'name' => 'John',
                'email' => 'john@john.com'
            ]
        ]);

        $output = $collection->execute(new FilterAction($params));

        $data = $output->data;

        $this->assertCount(1, $data);
        $this->assertArrayNotHasKey('name', $data);

        $genericRecipe2 = new GenericRecipe();
        $genericRecipe2->setIdentifier(FilterAction::class);

        $genericRecipe2->add([
            'filter' => true
        ]);

        $email->setRecipe($genericRecipe2);

        $output2 = $collection->execute(new FilterAction($params));

        $this->assertCount(0, $output2->data);
        
    }

    /** @test */
    public function setters_can_be_used_with_the_generic_recipe_to_make_setters_more_strict()
    {
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

    /** @test */
    public function setters_are_also_validated_when_the_method_all_is_used()
    {
        $genericRecipe = new GenericRecipe();
        $genericRecipe->setIdentifier(FilterAction::class);
        $genericRecipe->setSetters(['filter']);
        $genericRecipe->filter = true;

        $this->expectException(Exception::class);

        $genericRecipe->add([
            'notASetter' => true
        ]);
    }
    
    /** @test */
    public function modifiers_and_ignore_can_be_used_on_the_generic()
    {
        $genericRecipe = new GenericRecipe();
        $genericRecipe->setIdentifier(LabelValueAction::class);

        $genericRecipe->setModifiers([
            new BooleanModifier()
        ]);

        $genericRecipe->ignore();

        $this->assertCount(1, $genericRecipe->getModifiers());
        $this->assertTrue($genericRecipe->isIgnored());
        
    }
    
    /** @test */
    public function methods_fill_and_add_also_validate_setters()
    {
        $genericRecipe = new GenericRecipe();
        $genericRecipe->setIdentifier(LabelValueAction::class);
        $genericRecipe->setSetters(['label', 'value']);
        
        $genericRecipe->fill([
            'label' => 'New Label'
        ]);

        $genericRecipe->add([
            'value' => 'New Value'
        ]);

        $this->assertCount(2, $genericRecipe);

        $this->expectException(Exception::class);

        $genericRecipe->add([
            'otherValue' => 'Other Value'
        ]);

    }
}
