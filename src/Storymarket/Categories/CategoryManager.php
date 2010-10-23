<?php

class Storymarket_Categories_CategoryManager extends Storymarket_Base_Manager {
    public $resourceClass = 'Storymarket_Categories_Category';

    protected $_urlBit = 'category';

    protected function _baseUrl() {
        return "/content/{$this->_urlBit}/";
    }

    public function all() {
        return $this->_handler->doList($this->_baseUrl());
    }

    public function get($resource) {
        return $this->_handler->doGet("{$this->_baseUrl()}{$resource->id}/");
    }
}

