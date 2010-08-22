<?php

class Storymarket_Exceptions extends Exception {

    static public function fromResponse($status, $body) {
        return new self(null, $status, $body);
    }

    public function __construct($message = null, $code = null, $body = null) {
        $this->_body = $body;
        parent::__construct($message, $code);
    }

    public function getStatus() {
        return $this->getCode();
    }

    public function getBody() {
        return $this->_body;
    }
}
