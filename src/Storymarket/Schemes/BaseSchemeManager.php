<?php

class Storymarket_Schemes_BaseSchemeManager extends Storymarket_Base_Manager {
    public function all() {
        return $this->_handler->doList("/{$this->_url_bit}/");
    }

    public function get($resource) {
        return $this->_handler->doGet("/{$this->_url_bit}/{$resource->id}/");
    }
}
