<?php

namespace Chatagency\CrudAssistant;

use Closure;

/**
 * Input Base Class.
 */
abstract class Input
{
    /**
     * Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Label.
     *
     * @var string
     */
    protected $label;

    /**
     * Version.
     *
     * @var bool
     */
    protected $version;

    /**
     * Input attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Input Sub Elements.
     *
     * @var [type]
     */
    protected $subElements = [];

    /**
     * Input Type.
     */
    protected $type = null;

    /**
     * Input Actions.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Class construct.
     *
     * @param string $label
     */
    public function __construct(string $name, string $label = null, int $version = 1)
    {
        $this->name = $name;
        $this->label = $label ? $label : $name;
        $this->version = $version ? $version : 1;

        return$this;
    }

    /**
     * Sets input label.
     *
     * @param string $name
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Sets input attributes.
     *
     * @param string|Closure $value
     */
    public function setAttribute(string $name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Sets input sub elements.
     */
    public function setSubElements(array $subElements)
    {
        $this->subElements = $subElements;

        return $this;
    }

    /**
     * Sets input version.
     *
     * @param string $version
     *
     * @return self
     */
    public function setVersion(bool $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Sets input type.
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Returns input name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns input label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns input version.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Returns Input attributes.
     *
     * @return string|Closure
     */
    public function getAttribute(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /**
     * Returns Input attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Returns input sub elements.
     *
     * @return array
     */
    public function getSubElements()
    {
        return $this->subElements;
    }

    /**
     * Sets Action.
     *
     * @param $value
     *
     * @return self
     */
    public function setAction(string $type, $value)
    {
        $this->actions[$type] = $value;

        return $this;
    }

    /**
     * Returns action by type.
     *
     * @param string $type
     */
    public function getAction($type)
    {
        if (isset($this->actions[$type])) {
            return $this->actions[$type];
        }

        return null;
    }
}
