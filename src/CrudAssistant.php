<?php

declare(strict_types=1);

namespace Chatagency\CrudAssistant;

use BadMethodCallException;

/**
 * Crud Assistant Manager.
 */
class CrudAssistant
{
    /**
     * Action factory.
     *
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Input collection.
     *
     * @var InputCollection
     */
    protected $collection;

    /**
     * Construct.
     *
     * @return self
     */
    public function __construct(array $inputs = [], ActionFactory $actionFactory = null)
    {
        $this->actionFactory = $actionFactory ?? new ActionFactory(config('crud-assistant.actions'));
        $this->collection = new InputCollection($inputs, $this->actionFactory);

        return $this;
    }

    /**
     * Magic call method class tied
     * to collection and actions.
     *
     * @param $name
     * @param $arguments
     *
     * @throws BadMethodCallException
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        /**
         * Check if the method called is an action.
         */
        $action = $this->getActionBase($name);

        if ($action) {
            $params = !empty($arguments) ? $arguments[0] : [];

            /*
             * A data container must be passed
             * as the second param to the
             * execute method.
             */
            if (!$params instanceof DataContainer) {
                $params = new DataContainer($params);
            }

            return $this->collection->execute($action, $params);
        }

        /**
         * Check if the method called is a collection method.
         */
        if (method_exists($this->collection, $name)) {
            $object_array = [$this->collection, $name];

            return \call_user_func_array($object_array, $arguments);
        }

        throw new BadMethodCallException('Method '.$name.' not exists in '.__CLASS__, 500);
    }

    /**
     * Creates new instance of this class.
     *
     * @return self
     */
    public static function make(array $inputs = [], ActionFactory $actionFactory = null)
    {
        return new static($inputs, $actionFactory);
    }

    /**
     * Returns input collection.
     *
     * @return InputCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Returns action class name without path.
     *
     * @return string|null
     */
    protected function getActionBase(string $action)
    {
        $actionWithPath = $this->actionFactory->addNamespace($action);
        if( $this->actionFactory->isPackageAction($actionWithPath)) {
            return  $actionWithPath;
        }
        
        $actions = $this->actionFactory->getActions();

        foreach ($actions as $key => $value) {
            $base = substr(strrchr($value, '\\'), 1);
            if ($base == ucfirst($action)) {
                return $value;
            }
        }

        return null;
    }
}
