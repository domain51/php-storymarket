<?php

define('STORYMARKET_CLIENT_USER_AGENT', 'php-storymarket/' . Storymarket::VERSION);

class Storymarket_Client {
    public $baseUrl = null;
    public $userAgent = null;

    public function __construct(Storymarket $api) {
        $this->api = $api;
        $this->baseUrl = 'http://storymarket.com/api/v1';
        $this->userAgent = 'php-storymarket/' . Storymarket::VERSION;
    }

    /**
     * @todo refactor to allow other HTTP libraries to be used
     * @todo refactor to make more testable -- this is doing way too much
     */
    public function request($url, $method, array $opts = array()) {
        $url = implode('/', array($this->baseUrl, $url));

        if (empty($opts['header'])) {
            $opts['header'] = array();
        }
        $opts['headers']['User-Agent'] = $this->userAgent;
        $opts['headers']['Authorization'] = $this->api->api_key;

        $headers = array();
        foreach ($opts['headers'] as $k => $v) {
            $headers[] = "{$k}: {$v}";
        }

        $c = curl_init();
        curl_setopt_array($c, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => $method == 'POST',
        ));
        if (isset($opts['body'])) {
            curl_setopt($c, CURLOPT_POSTFIELDS, $opts['body']);
        }

        $response = curl_exec($c);
        $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if (in_array($status, array(400, 401, 403, 404, 405, 406, 413, 500))) {
            throw Storymarket_Exceptions::fromResponse($status, $response);
        }
        # TODO: should return all headers in addition to body
        return json_decode($response);
    }

    private function _requestWithBody($url, $method, $body=null) {
        $opts = array();
        if (!empty($body)) {
            $opts['body'] = $body;
        }
        return $this->request($url, $method, $opts);
     }

    public function get($url) {
        return $this->request($url, 'GET');
    }

    public function post($url, $body=null) {
        return $this->_requestWithBody($url, 'POST', $body);
    }

    public function put($url, $body=null) {
        return $this->_requestWithBody($url, 'PUT', $body);
    }

    public function delete($url) {
        return $this->request($url, 'DELETE');
    }
}

