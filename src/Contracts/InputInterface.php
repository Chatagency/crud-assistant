<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant\Contracts;

use Chatagency\CrudAssistant\DataContainer;

/**
 * Input Collection Interface.
 */
interface InputInterface
{
    /**
     * Class construct.
     *
     * @return self
     */
    public function __construct(string $name = null, string $label = null, ActionFactoryInterface $actionFactory = null);

    /**
     * Sets input name.
     *
     * @return self
     */
    public function setName(string $name);

    /**
     * Sets input label.
     *
     * @return self
     */
    public function setLabel(string $label);

    /**
     * Sets input attributes.
     *
     * @param mixed $value
     */
    public function setAttribute(string $name, $value);

    /**
     * Sets input sub elements.
     *
     * @return self
     */
    public function setSubElements(InputCollectionInterface $subElements);

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
    public function getType();

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
     * @return InputCollectionInterface
     */
    public function getSubElements();

    /**
     * Sets Recipe.
     *
     * @param $value
     *
     * @return self
     */
    public function setRecipe(string $type, $value);

    /**
     * Returns recipe by type.
     *
     * @return mixed
     */
    public function getRecipe(string $type);

    /**
     * Executes Action.
     *
     * @param DataContainer $output
     *
     * @return DataContainer
     */
    public function execute(ActionInterface $action);
}
