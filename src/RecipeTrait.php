<?php

namespace Chatagency\CrudAssistant;

/**
 * Recipe Trait
 */
trait RecipeTrait
{
    /**
     * Recipe identifier.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Ignore input.
     *
     * @var bool
     */
    protected $ignored = false;

    /**
     * Input value modifiers.
     *
     * @var array
     */
    protected $modifiers = [];

    /**
     * Construct can receive a data array.
     *
     * @return self
     */
    public function __construct(array $data = [])
    {
        foreach($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Returns recipe identifier.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the ignore value.
     *
     * @param mixed $ignore
     *
     * @return self
     */
    public function ignore($ignore = true)
    {
        $this->ignored = $ignore;

        return $this;
    }

    /**
     * Adds modifier to the array.
     *
     * @return self
     */
    public function setModifier(Modifier $modifier)
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    /**
     * Adds multiple modifiers to the
     * modifiers array.
     *
     * @return self
     */
    public function setModifiers(array $modifiers)
    {
        foreach ($modifiers as $modifier) {
            $this->setModifier($modifier);
        }

        return $this;
    }

    /**
     * Returns modifiers array.
     *
     * @return array
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Checks if input is ignored.
     *
     * @return bool
     */
    public function isIgnored()
    {
        return $this->ignored;
    }

}
