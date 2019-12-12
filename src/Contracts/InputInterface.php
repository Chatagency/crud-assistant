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
     * @return self
     */
    public function setLabel(string $label);

    /**
     * Sets input attributes.
     *
     * @param string $value
     */
    public function setAttribute(string $name, $value);

    /**
     * Sets input sub elements.
     *
     * @return self
     */
    public function setSubElements(array $subElements);

    /**
     * Sets input version.
     *
     * @return self
     */
    public function setVersion(int $version);

    /**
     * Sets input type.
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
    public function gettype();

    /**
     * Returns Input attributes.
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
     * Sets Action.
     *
     * @param $value
     *
     * @return self
     */
    public function setAction(string $type, $value);

    /**
     * Sets Recipe.
     *
     * @param $value
     *
     * @return self
     */
    public function setRecipe(string $type, $value);

    /**
     * Returns action by type.
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getAction($type);
}
