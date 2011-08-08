<?php

class Storymarket_SubTypes_subTypeManager extends Storymarket_Base_Manager {
    public $resourceClass = 'Storymarket_SubTypes_SubType';

    protected $_urlBit = 'sub_type';

    protected function _baseUrl() {
        return "/content/{$this->_urlBit}/";
    }

    public function all() {
        return $this->_handler->doList($this->_baseUrl());
    }

    public function filter($params) {
        /*
        Example:
         $params = array('is_default'=> 1, 'type__model'=>'text')
        */
        $qs = http_build_query($params)
        return $this->_handler->doList($this->_baseUrl().'?'.$qs);
    }
    // Shortcuts
    public function defaults() {
        return $this->filter(array('is_default'=> 1));
    }

    public function for_type($type) {
        return $this->filter(array('type__model'=> $type));
    }

    public function get($resource) {
        $id = is_object($resource) ? $resource->id : $resource;
        return $this->_handler->doGet("{$this->_baseUrl()}{$id}/");
    }
}

