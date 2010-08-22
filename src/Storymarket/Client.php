<?php

class Storymarket_Client {

    public function get($url) {
        return $this->request($url, 'GET');
    }

    public function post($url) {
        return $this->request($url, 'POST');
    }

    public function put($url) {
        return $this->request($url, 'PUT');
    }

    public function delete($url) {
        return $this->request($url, 'DELETE');
    }
}

