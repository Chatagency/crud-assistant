<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use Chatagency\CrudAssistant\Contracts\ActionFactoryInterface;
use InvalidArgumentException;

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
     * Input Recipes.
     *
     * @var array
     */
    protected $recipes = [];

    /**
     * Action Factory
     *
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @return self
     */
    public function __construct(string $name, string $label = null, int $version = 1, ActionFactoryInterface $actionFactory = null)
    {
        $this->name = $name;
        $this->label = $label ? $label : $name;
        $this->version = $version ? $version : 1;

        $this->actionFactory = $actionFactory ?? new ActionFactory();

        return $this;
    }

    /**
     * Sets input label.
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
     * @param string $value
     */
    public function setAttribute(string $name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Sets input sub elements.
     *
     * @return self
     */
    public function setSubElements(array $subElements)
    {
        $this->subElements = $subElements;

        return $this;
    }

    /**
     * Sets input version.
     *
     * @return self
     */
    public function setVersion(int $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Sets input type.
     *
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
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
     * Returns input type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns Input attributes.
     *
     * @return string|null
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
     * Sets Recipe.
     *
     * @param $value
     *
     * @return self
     */
    public function setRecipe(string $action, $value)
    {
        if(!$this->actionFactory->isAction($action)) {
            throw new InvalidArgumentException('The action '.$action.' is not a valid action', 500);
        }
        
        $this->recipes[$action] = $value;

        return $this;
    }

    /**
     * Returns recipe by type.
     *
     * @return string|null
     */
    public function getRecipe(string $type)
    {
        if (isset($this->recipes[$type])) {
            return $this->recipes[$type];
        }

        return null;
    }

    /**
     * Get recipe alias.
     *
     * @return string|null
     *
     * @deprecated on version 0.1.1
     * @see getRecipe()
     */
    public function getAction(string $type)
    {
        return $this->getRecipe($type);
    }

    /**
     * Unset attribute.
     *
     * @return self
     */
    public function unsetAttribute(string $key)
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }
}
