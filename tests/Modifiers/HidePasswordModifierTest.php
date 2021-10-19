<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifiers\HidePasswordModifier;

class HidePasswordModifierTest extends TestCase
{
  
  /** @test */
  public function the_hide_password_modifier_obscures_a_string () 
  {
    $password = 'secure_password';

    $modifier = new HidePasswordModifier();

    $modifiedPassword = $modifier->modify($password);

    $this->assertNotEquals($password, $modifiedPassword);
    $this->assertEquals($modifiedPassword, $modifier->getDefaultValue());
  }

  /** @test */
  public function a_modifier_value_can_be_passed_to_the_modifier () 
  {
    $password = 'secure_password';
    $value = '000000';

    $modifier = new HidePasswordModifier(new DataContainer([
        'value' => $value,
    ]));

    $modifiedPassword = $modifier->modify($password);

    $this->assertNotEquals($password, $modifiedPassword);
    $this->assertEquals($modifiedPassword, $value);
  }
}
