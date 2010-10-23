<?php

class Storymarket_Categories_CategoryManager extends Storymarket_Base_Manager {
    public $resourceClass = 'Storymarket_Categories_Category';

    public function all() {
        return $this->_handler->doList('/content/category/');
    }

    public function get($resource) {
        return $this->_handler->doGet("/content/category/{$resource->id}/");
    }
}

