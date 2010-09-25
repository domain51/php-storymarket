<?php

class Storymarket_Content_ContentManager extends Storymarket_Base_Manager {
    public $_api = null;
    public $_resourceClass = 'Storymarket_Base_Resource';
    public $_handler = null;
    public $_url_bit = null;
    public $_flattenFields = array(
        'category',
        'author',
        'title',
        'org',
        'tags',
    );

    public function __construct($api, $handler=null, $url_bit=null) {
        parent::__construct($api, $handler);
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
        $data = $this->toArray($resource);
        return $this->_handler->doCreate($this->_buildUrl(), $data);
    }

    public function update($resource, $data=null) {
        if (is_null($data)) {
            $data = $resource;
        }
        $resourceId = is_array($resource) ? $resource['id'] : $resource->id;
        $data = $this->toArray($data);
        return $this->_handler->doUpdate($this->_buildUrl($resourceId), $data);
    }

    public function toArray($resource) {
        if (is_subclass_of($resource, 'Storymarket_Base_Resource')) {
            $data = array();
            foreach ($this->_flattenFields as $k) {
                if (!empty($resource->$k)) {
                    $data[$k] = $resource->$k;
                }
            }
        } else {
            $data = $resource;
        }
        return $data;
    }
}
