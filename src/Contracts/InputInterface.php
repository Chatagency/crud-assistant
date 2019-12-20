<?php

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Input Collection Interface.
 */
interface InputInterface
{
    /**
     * Class construct.
     *
     * @param string $label
     * @param string $label
     *
     * @return self
     */
    public function __construct(string $name, string $label = null, int $version = 1);

    /**
     * Sets input label.
     *
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label);

    /**
     * Sets input attributes.
     *
     * @param string $name
     * @param string $value
     */
    public function setAttribute(string $name, $value);

    /**
     * Sets input sub elements.
     *
     * @param array $subElements
     *
     * @return self
     */
    public function setSubElements(array $subElements);

    /**
     * Sets input version.
     *
     * @param int $version
     *
     * @return self
     */
    public function setVersion(int $version);

    /**
     * Sets input type.
     *
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type);

    /**
     * Returns input name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns input label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Returns input version.
     *
     * @return int
     */
    public function getVersion();

    /**
     * Returns input type.
     *
     * @return string
     */
    public function getType();

    /**
     * Returns Input attributes.
     *
     * @param string $name
     *
     * @return string|null
     */
    public function getAttribute(string $name);

    /**
     * Returns Input attributes.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Returns input sub elements.
     *
     * @return array
     */
    public function getSubElements();

    /**
     * Set recipe alias.
     *
     * @param string $type
     * @param $value
     *
     * @return self
     */
    public function setAction(string $type, $value);

    /**
     * Sets Recipe.
     *
     * @param string $type
     * @param $value
     *
     * @return self
     */
    public function setRecipe(string $type, $value);

    /**
     * Returns recipe by type.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getRecipe(string $type);

    /**
     * Get recipe alias.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getAction(string $type);
}
