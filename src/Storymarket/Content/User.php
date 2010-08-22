<?php

class Storymarket_Content_User {
    private $_data = array(
        'username' => '',
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    );

    public function __construct(array $data = array()) {
        $this->_addKnownValuesToStoredData($data);
    }

    private function _addKnownValuesToStoredData($data) {
        $this->_data = array_merge($this->_data, array_intersect_key($data, $this->_data));
    }

    public function __get($k) {
        return $this->_data[$k];
    }

    public function __isset($k) {
        return isset($this->_data[$k]);
    }
}
