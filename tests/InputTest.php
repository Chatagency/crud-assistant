<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Tests;

use Chatagency\CrudAssistant\Actions\LabelValueAction;
use Chatagency\CrudAssistant\Contracts\InputCollectionInterface;
use Chatagency\CrudAssistant\Contracts\InputInterface;
use Chatagency\CrudAssistant\InputCollection;
use Chatagency\CrudAssistant\Inputs\OptionInput;
use Chatagency\CrudAssistant\Inputs\SelectInput;
use Chatagency\CrudAssistant\Inputs\TextInput;
use Chatagency\CrudAssistant\Recipes\LabelValueRecipe;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testAnInputCanBeCreatedWithJustAName()
    {
        $input = new TextInput('name');

        $this->assertEquals('name', $input->getName());
        $this->assertEquals('name', $input->getLabel());
        $this->assertEquals(1, $input->getVersion());
    }

    public function testAnActionRecipeCanCanBeAddedToAnInput()
    {
        $value = [
            'label' => 'This is an email',
        ];

        $input = new TextInput('email', 'Email');
        $input->setType('email');
        $input->setRecipe(new LabelValueRecipe($value['label']));

        $this->assertEquals($input->getRecipe(LabelValueAction::class)->label, $value['label']);
    }

    public function testIfRecipeDoesNotExistInClassNullIsReturned()
    {
        $input = new TextInput('email', 'Email');
        $input->setType('email');

        $this->assertNull($input->getRecipe(LabelValueAction::class));
    }

    public function testTheNameLabelVersionAndTypeCanBeSetAfterTheInputHasBeenInstantiated()
    {
        $input = new TextInput('email');

        $input->setName('new_email');
        $input->setType('email');
        $input->setLabel('Add your email');
        $input->setVersion(2);

        $this->assertEquals('new_email', $input->getName());
        $this->assertEquals('Add your email', $input->getLabel());
        $this->assertEquals('email', $input->getType());
        $this->assertEquals(2, $input->getVersion());
    }

    public function testAnArbitraryAttributeCanBeAddedToAnInputClass()
    {
        $input = new TextInput('email');
        $input->setType('email');

        $this->assertNull($input->getAttribute('id'));

        $input->setAttribute('id', 'FormEmail');

        $this->assertEquals('FormEmail', $input->getAttribute('id'));
        $this->assertCount(1, $input->getAttributes());
    }

    public function testAnArbitraryAttributeCanBeRemovedFromAnInputClass()
    {
        $input = new TextInput('email');
        $input->setType('email');

        $this->assertNull($input->getAttribute('id'));

        $input->setAttribute('id', 'FormEmail');

        $this->assertEquals('FormEmail', $input->getAttribute('id'));
        $this->assertCount(1, $input->getAttributes());

        $input->unsetAttribute('id');

        $this->assertCount(0, $input->getAttributes());
    }

    public function testSubElementsCanBeAddedToAnInputClass()
    {
        $input = new SelectInput('hobbies', 'Your Hobbies');
        $hobbies = new InputCollection();
        $hobbies->setInputs([
            new OptionInput('watch_tv'),
            new OptionInput('play_pokemon go'),
            new OptionInput('drink_wine'),
        ]);

        $input->setSubElements($hobbies);

        $this->assertCount(3, $input->getSubElements());
    }

    public function testSubElementsAreAnInputCollectionWithInputs()
    {
        $input = new SelectInput('hobbies', 'Your Hobbies');
        $hobbies = new InputCollection();
        $hobbies->setInputs([
            new OptionInput('watch_tv'),
        ]);
        $input->setSubElements($hobbies);

        $subElements = $input->getSubElements();

        $this->assertInstanceOf(InputCollectionInterface::class, $subElements);
        $this->assertInstanceOf(InputInterface::class, $subElements->getInput('watch_tv'));
    }
}
