<?php

namespace Chatagency\CrudAssistant\Tests\Modifiers;

use PHPUnit\Framework\TestCase;
use Chatagency\CrudAssistant\DataContainer;
use Chatagency\CrudAssistant\Modifiers\UniqueMigrationModifier;
use Illuminate\Database\Schema\Blueprint;

class UniqueMigrationModifierTest extends TestCase
{
    /** @test */
    public function the_unique_migration_adds_the_unique_modifier_to_the_migration()
    {
        $blueprint = new Blueprint('contacts', function (Blueprint $table){
            $table = (new UniqueMigrationModifier())->modify($table->string('name'), null);
        });
        
        $columns = $blueprint->getColumns();
        $attributes = $columns[0]->getAttributes();
        
        $this->assertTrue($attributes['unique']);
        
    }
    
}
