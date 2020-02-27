<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\Modifiers\SanitizedModifier;
use Chatagency\CrudAssistant\DataContainer;

class SanitizedModifierTest extends TestCase
{
    /** @test */
    public function the_sanitized_modifier_decodes_the_value()
    {
        $modifer = new SanitizedModifier();
        $value = "This aren't true";
        $valueEncoded = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        
        $newValue = $modifer->modify($valueEncoded, new DataContainer([]));
        
        $this->assertEquals($value, $newValue);
        $this->assertNotEquals($valueEncoded, $newValue);
        
    }
    
}