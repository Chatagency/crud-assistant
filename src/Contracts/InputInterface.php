<?php

namespace Chatagency\CrudAssistant\Contracts;

/**
 * Input Collection Interface
 */
interface InputInterface
{
    /**
     * Class construct
     * @param string $name
     * @param string $label
     * @param int $version
     */
    public function __construct(string $name, string $label = null, int $version = 1);
    
    /**
     * Sets input label
     * @param string $name
     * @return self
     */
    public function setLabel(string $label);
    
    /**
     * Sets input attributes
     * @param string $name
     * @param string|Closure $value
     */
    public function setAttribute(string $name, $value);
    
    /**
     * Sets input sub elements
     * @param array $subElements
     */
    public function setSubElements(array $subElements);
    
    /**
     * Sets input version
     * @param string $version
     * @return self
     */
    public function setVersion(bool $version);
    
    /**
     * Sets input type
     * @param string $type
     */
    public function setType(string $type);
    
    /**
     * Returns input name
     * @return string
     */
    public function getName();
    
    /**
     * Returns input label
     * @return string
     */
    public function getLabel();
    
    /**
     * Returns input version
     * @return int
     */
    public function getVersion();
    
    /**
     * Returns Input attributes
     * @return string|Closure
     */
    public function getAttribute(string $name);
    
    /**
     * Returns Input attributes
     * @return array
     */
    public function getAttributes();
    
    /**
     * Returns input sub elements
     * @return array
     */
    public function getSubElements();
    
    /**
     * Sets Action
     * @param string $type
     * @param $value
     * @return self
     */
    public function setAction(string $type, $value);
    
    /**
     * Returns action by type
     * @param string $type
     */
    public function getAction($type);
}
