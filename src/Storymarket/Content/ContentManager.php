<?php

class Storymarket_Content_ContentManager {
    protected $_api = null;
    protected $_resourceClass = 'Storymarket_Base_Resource';
    protected $_url_bit = null;

    public function __construct($api, $handler=null, $url_bit=null) {
        $this->_handler = empty($handler) ? new Storymarket_RequestHandler($api) : $handler;
        $this->_api = $api;
        $this->_url_bit = $url_bit;
    }

    private function _buildUrl() {
        $args = func_get_args();
        if (!empty($args)) {
            $extra = implode('/', $args) . '/';
        }
        return sprintf('/content/%s/%s', $this->_url_bit, $extra);
    }

    public function all() {
        return $this->_handler->doList($this->_buildUrl());
    }

    public function get($resource) {
        return $this->_handler->doGet($this->_buildUrl($resource->id));
    }

    public function delete($resource) {
        return $this->_handler->doDelete($this->_buildUrl($resource->id));
    }

    public function create($resource) {
        $data = method_exists($resource, 'toArray') ? $resource->toArray() : $resource;
        return $this->_handler->doCreate($this->_buildUrl(), $data);
    }

    public function update($resource) {
        $data = method_exists($resource, 'toArray') ? $resource->toArray() : $resource;
        return $this->_handler->doUpdate($this->_buildUrl($data['id']), $data);
    }
}
