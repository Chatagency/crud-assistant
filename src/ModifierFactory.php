<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Exception;

/**
 * Modifier Factory.
 */
class ModifierFactory
{
    /**
     * Modifier classes path.
     *
     * @var string
     */
    public const PATH = '\Chatagency\CrudAssistant\Modifiers\\';

    /**
     * Returns modifier instance.
     *
     * @throws Exception
     *
     * @return Modifier
     */
    public static function make(string $type)
    {
        $typeOrig = $type;

        if (!class_exists($type)) {
            $type = self::PATH.$type;
        }

        if (!class_exists($type)) {
            throw new Exception('The Modifier '.$typeOrig.' could not be found or does not exist', 500);
        }

        $modifier = new $type();

        if (!$modifier instanceof Modifier) {
            throw new Exception('The Modifier '.$typeOrig.' is not an instance of '.Modifier::class, 500);
        }

        return $modifier;
    }
}
