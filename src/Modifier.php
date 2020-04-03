<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

/**
 * Modifer Base Class.
 */
abstract class Modifier
{
    /*
     * Option Data
     *
     * @var DataContainer
     */
    protected $data = null;
    
    /**
     * Construct for dependency injection
     */
    public function __construct(DataContainer $data = null)
    {
        $this->data = $data;
    }
    
    /**
     * Returns option data
     *
     * @return DataContainer|null
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Modifier must implement the
     * modify method
     * 
     * @var $value
     */
    abstract public function modify($value, DataContainer $data = null);
    
}
