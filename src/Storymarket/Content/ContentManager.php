<?php

class Storymarket_Content_ContentManager extends Storymarket_Base_Manager {
    public $_api = null;
    public $_resourceClass = 'Storymarket_Base_Resource';
    public $_handler = null;
    public $_url_bit = null;

    public function __construct($api, $handler=null, $url_bit=null) {
        parent::__construct($api);
        $this->_handler = empty($handler) ? new Storymarket_RequestHandler($api, $this) : $handler;
        $this->_url_bit = $url_bit;
        if (is_null($this->_url_bit)) {
            $exploded = explode('_', get_class($this));
            $this->_url_bit = strtolower(str_replace('Manager', '', array_pop($exploded)));
        }
    }

    protected function _buildUrl() {
        $args = func_get_args();
        $extra = !empty($args) ? implode('/', $args) . '/' : '';
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

    public function update($resource, $data=null) {
        if (is_null($data)) {
            $data = method_exists($resource, 'toArray') ? $resource->toArray() : $resource;
        }
        return $this->_handler->doUpdate($this->_buildUrl($data['id']), $data);
    }
}
