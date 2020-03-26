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

    $modifer = new HidePasswordModifier();

    $modifiedPassword = $modifer->modify($password, new DataContainer());

    $this->assertNotEquals($password, $modifiedPassword);
    $this->assertEquals($modifiedPassword, $modifer->getDefaultValue());
  }

  /** @test */
  public function a_modifer_value_can_be_passed_to_the_modifier () 
  {
    $password = 'secure_password';
    $value = '000000';

    $modifer = new HidePasswordModifier();

    $modifiedPassword = $modifer->modify($password, new DataContainer([
      'value' => $value,
    ]));

    $this->assertNotEquals($password, $modifiedPassword);
    $this->assertEquals($modifiedPassword, $value);
  }
}
