<?php

/**
 * Super class for all specific Managers
 *
 * Provides basic CRUD operations for sub-classes
 */
abstract class Storymarket_Base_Manager
{
    /**
     * A reference to the instantiated {@link Storymarket} object this was
     * created from.
     *
     * @var $_api Storymarket
     */
    public $_api = null;

    /**
     * Should be overriden by sub-classes to provide the specific resource
     * class for this instance of Manager
     *
     * @var $_resource_class string
     */
    protected $_resource_class = null;

    /**
     * Handle instantiation
     *
     * @param $api Storymarket
     */
    public function __construct(Storymarket $api, $handler=null) {
        $this->_api = $api;
        $this->_handler = empty($handler) ? new Storymarket_RequestHandler($api, $this) : $handler;
    }

    abstract public function all();
    abstract public function get($resource);
}

