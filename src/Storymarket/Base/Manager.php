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
    protected $_api = null;

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
    public function __construct(Storymarket $api) {
        $this->_api = $api;
    }

    /**
     * @todo document
     */
    abstract public function all();

    /**
     * @todo document
     */
    abstract public function get();

    protected function _list($url) {
        list($response, $body) = $this->api->client->get($url);
        $ret = array();
        foreach ($body as $res) {
            $ret[] = new $this->_resource_class($this, $res);
        }
        return $ret;
    }

    protected function _get($url) {
        list($response, $body) = $this->api->client->get($url);
        return new $this->_resource_class($this, $body);
    }

    protected function _create($url, $body) {
        list($response, $body) = $this->api->client->post($url, $body);
        return new $this->_resource_class($this, $body);
    }

    protected function _delete($url) {
        $this->api->client->delete($url);
    }

    protected function _update($url, $body) {
        $this->api->client->put($url, $body);
    }
}

